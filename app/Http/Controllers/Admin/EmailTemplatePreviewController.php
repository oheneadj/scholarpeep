<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\View;

class EmailTemplatePreviewController extends Controller
{
    public function show(EmailTemplate $record): View
    {
        $previewData = $this->getMockData($record->slug);
        
        $content = Blade::render(
            $record->content ?? '',
            $previewData
        );

        return view('emails.dynamic', [
            'content' => $content,
            'preheader' => $record->preheader,
        ]);
    }

    protected function getMockData(string $slug): array
    {
        $user = new User([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'id' => 1,
        ]);

        $scholarship = Scholarship::query()->inRandomOrder()->first() ?? new Scholarship([
            'title' => 'Global Excellence Scholarship',
            'provider_name' => 'Education Foundation',
            'amount' => 5000,
            'primary_deadline' => now()->addDays(30),
        ]);

        return match ($slug) {
            'welcome' => [
                'user' => $user,
            ],
            'scholarship-match' => [
                'user' => $user,
                'scholarships' => Scholarship::query()->limit(3)->get(),
            ],
            'deadline-reminder' => [
                'user' => $user,
                'scholarship' => $scholarship,
                'days_left' => 5,
            ],
            default => [
                'user' => $user,
                'scholarship' => $scholarship,
                'scholarships' => Scholarship::query()->limit(3)->get(),
            ],
        };
    }
}
