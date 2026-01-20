<?php

namespace App\Services;

use App\Models\User;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Illuminate\Support\Facades\Log;

class GoogleCalendarService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri(config('services.google.redirect'));
        $this->client->addScope(Calendar::CALENDAR_EVENTS);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('consent');
    }

    /**
     * Set the user and handle token refresh if necessary
     */
    protected function setUser(User $user)
    {
        $token = $user->google_calendar_token;

        if (!$token) {
            return false;
        }

        $this->client->setAccessToken($token);

        if ($this->client->isAccessTokenExpired()) {
            if ($this->client->getRefreshToken()) {
                $newToken = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                $user->update(['google_calendar_token' => array_merge($token, $newToken)]);
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Create a calendar event for a scholarship deadline
     */
    public function createDeadlineEvent(User $user, $scholarship, $deadlineDate)
    {
        if (!$this->setUser($user)) {
            Log::warning("User {$user->id} has no valid Google Calendar token.");
            return false;
        }

        $calendarService = new Calendar($this->client);

        $event = new Event([
            'summary' => "Scholarship Deadline: {$scholarship->title}",
            'location' => $scholarship->provider_name,
            'description' => "Reminder for scholarship application: " . route('scholarships.show', $scholarship),
            'start' => [
                'date' => $deadlineDate->format('Y-m-d'),
                'timeZone' => config('app.timezone'),
            ],
            'end' => [
                'date' => $deadlineDate->format('Y-m-d'),
                'timeZone' => config('app.timezone'),
            ],
            'reminders' => [
                'useDefault' => FALSE,
                'overrides' => [
                    ['method' => 'email', 'minutes' => 24 * 60 * 7], // 1 week before
                    ['method' => 'popup', 'minutes' => 60 * 24],    // 1 day before
                ],
            ],
        ]);

        try {
            $calendarId = 'primary';
            $event = $calendarService->events->insert($calendarId, $event);
            return $event->htmlLink;
        } catch (\Exception $e) {
            Log::error("Failed to create Google Calendar event: " . $e->getMessage());
            return false;
        }
    }
}
