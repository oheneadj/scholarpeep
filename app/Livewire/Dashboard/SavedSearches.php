<?php

namespace App\Livewire\Dashboard;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\SavedSearch;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.dashboard')]
class SavedSearches extends Component
{
    public function delete($id)
    {
        $search = SavedSearch::where('user_id', '=', Auth::id(), 'and')->find($id);

        if ($search) {
            $search->delete();
            $this->dispatch('search-deleted');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.saved-searches', [
            'searches' => SavedSearch::where('user_id', '=', Auth::id(), 'and')
                ->latest()
                ->get()
        ]);
    }
}
