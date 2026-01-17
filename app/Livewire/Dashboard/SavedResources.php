<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.dashboard')]
class SavedResources extends Component
{
    use WithPagination;

    public function render()
    {
        $resources = Auth::user()->savedResources()
            ->with('resource')
            ->latest()
            ->paginate(12)
            ->through(fn ($saved) => $saved->resource);

        return view('livewire.dashboard.saved-resources', [
            'resources' => $resources,
        ]);
    }
}
