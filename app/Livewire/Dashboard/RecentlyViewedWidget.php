<?php

namespace App\Livewire\Dashboard;

use App\Models\Scholarship;
use Livewire\Component;

class RecentlyViewedWidget extends Component
{
    public $scholarships = [];

    public function mount()
    {
        $this->loadRecentlyViewed();
    }

    public function loadRecentlyViewed()
    {
        $ids = session()->get('recently_viewed_scholarships', []);
        
        if (empty($ids)) {
            $this->scholarships = collect();
            return;
        }

        // Maintain the order of the IDs in the session (most recent first)
        $this->scholarships = Scholarship::whereIn('id', $ids)
            ->where('status', \App\Enums\ScholarshipStatus::ACTIVE)
            ->with(['countries', 'scholarshipTypes'])
            ->get()
            ->sortBy(function ($scholarship) use ($ids) {
                return array_search($scholarship->id, $ids);
            })
            ->values();
    }

    public function render()
    {
        return view('livewire.dashboard.recently-viewed-widget');
    }
}
