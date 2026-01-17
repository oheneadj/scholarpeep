<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class ToolsIndex extends Component
{
    public function render()
    {
        $tools = [
            [
                'title' => 'GPA Calculator',
                'description' => 'Calculate your high school or college GPA accurately with our easy-to-use tool.',
                'icon' => 'calculator',
                'color' => 'blue',
                'link' => '#',
            ],
            [
                'title' => 'Statement of Purpose Generator',
                'description' => 'Draft a compelling Statement of Purpose for your scholarship applications.',
                'icon' => 'document-text',
                'color' => 'purple',
                'link' => '#',
            ],
            [
                'title' => 'Essay Checker',
                'description' => 'Get instant feedback on your scholarship essays to improve grammar and tone.',
                'icon' => 'pencil',
                'color' => 'green',
                'link' => '#',
            ],
            [
                'title' => 'Deadline Tracker',
                'description' => 'Keep track of all your scholarship application deadlines in one place.',
                'icon' => 'calendar',
                'color' => 'orange',
                'link' => '#',
            ],
        ];

        return view('livewire.pages.tools-index', [
            'tools' => $tools
        ])->layout('layouts.frontend');
    }
}
