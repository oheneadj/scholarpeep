<?php

namespace App\Livewire\Pages;

use App\Models\SuccessStory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.frontend')]
class SuccessStoriesIndex extends Component
{
    use WithPagination;

    public function render()
    {
        $stories = SuccessStory::approved()
            ->latest()
            ->paginate(12);

        return view('livewire.pages.success-stories-index', [
            'stories' => $stories,
        ])->layoutData([
            'title' => app(\App\Settings\SeoSettings::class)->stories_title ?? 'Success Stories - Scholarpeep',
            'description' => app(\App\Settings\SeoSettings::class)->stories_description ?? 'Read inspiring stories from students who won life-changing scholarships. Learn from their experiences.',
        ]);
    }
}
