<?php

namespace App\Livewire\Dashboard;

use App\Models\SavedScholarship;
use Carbon\Carbon;
use Livewire\Component;

class Calendar extends Component
{
    public $month;
    public $year;
    public $days = [];
    public $selectedDate = null;
    public $selectedDateDeadlines = [];

    public function mount()
    {
        $this->month = now()->month;
        $this->year = now()->year;
        $this->calculateDays();
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $dayData = collect($this->days)->firstWhere('date', $date);
        $this->selectedDateDeadlines = $dayData ? $dayData['deadlines'] : [];
    }

    public function previousMonth()
    {
        $date = Carbon::create($this->year, $this->month, 1)->subMonth();
        $this->month = $date->month;
        $this->year = $date->year;
        $this->calculateDays();
    }

    public function nextMonth()
    {
        $date = Carbon::create($this->year, $this->month, 1)->addMonth();
        $this->month = $date->month;
        $this->year = $date->year;
        $this->calculateDays();
    }

    public function calculateDays()
    {
        $date = Carbon::create($this->year, $this->month, 1);
        $daysInMonth = $date->daysInMonth;
        $firstDayOfWeek = $date->dayOfWeek; // 0 (Sun) to 6 (Sat)

        $this->days = [];

        // Add padding for previous month
        for ($i = 0; $i < $firstDayOfWeek; $i++) {
            $this->days[] = [
                'date' => null,
                'isCurrentMonth' => false,
                'deadlines' => [],
            ];
        }

        // Fetch deadlines for this month
        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();

        $deadlines = auth()->user()->savedScholarships()
            ->with('scholarship')
            ->whereHas('scholarship', function($q) use ($startDate, $endDate) {
                $q->whereBetween('primary_deadline', [$startDate, $endDate]);
            })
            ->get()
            ->groupBy(function($s) {
                return $s->scholarship->primary_deadline->format('Y-m-d');
            });

        // Add actual days
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = Carbon::create($this->year, $this->month, $day)->format('Y-m-d');
            $this->days[] = [
                'day' => $day,
                'date' => $currentDate,
                'isCurrentDate' => $currentDate === now()->format('Y-m-d'),
                'isCurrentMonth' => true,
                'deadlines' => $deadlines->get($currentDate, collect())->map(fn($s) => [
                    'id' => $s->id,
                    'title' => $s->scholarship->title,
                    'status' => $s->status->value,
                ]),
            ];
        }
    }

    public function addToGoogleCalendar($scholarshipId)
    {
        $user = auth()->user();

        // Check if user has connected Google Calendar
        if (!$user->google_calendar_token) {
            return redirect()->route('google.login');
        }

        try {
            // Configure Spatie Google Calendar with user's token
            // Note: In a real app complexity, we'd handle token refresh here.
            // For this implementation, we assume the access token is valid or we'd need a service to handle it.
            // Spatie package usually expects specific config. We might need to override it dynamically 
            // or use the Google Client directly with the token.
            
            // Simpler approach for this specific "User's Calendar": 
            // We use the token to instantiate a Google Client and insert the event.
            
            $client = new \Google\Client();
            $client->setAccessToken($user->google_calendar_token);

            if ($client->isAccessTokenExpired()) {
                // Return to login if expired (simplest handling without refresh logic for now)
                 return redirect()->route('google.login');
            }

            $service = new \Google\Service\Calendar($client);
            $scholarship = \App\Models\Scholarship::findOrFail($scholarshipId);
            
            $event = new \Google\Service\Calendar\Event([
                'summary' => "Deadline: {$scholarship->title}",
                'description' => "Don't forget to submit your application for {$scholarship->title}!\n\nLink: " . route('scholarships.show', $scholarship),
                'start' => [
                    'date' => $scholarship->primary_deadline->format('Y-m-d'),
                ],
                'end' => [
                    'date' => $scholarship->primary_deadline->addDay()->format('Y-m-d'),
                ],
            ]);

            $calendarId = 'primary';
            $service->events->insert($calendarId, $event);
            
            $this->dispatch('notify', message: 'Event added to your Google Calendar!');

        } catch (\Exception $e) {
            \Log::error('Google Calendar Add Error: ' . $e->getMessage());
            // Fallback or error notification
            $this->dispatch('notify', message: 'Failed to add event. Please reconnect Google Calendar.');
             return redirect()->route('google.login');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.calendar');
    }
}
