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
    use \App\Livewire\Traits\CanSaveResource;
    
    public string $search = '';
    public string $selectedType = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedType' => ['except' => ''],
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function filterByType(string $type): void
    {
        $this->selectedType = $this->selectedType === $type ? '' : $type;
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'selectedType']);
        $this->resetPage();
    }

    public function mount(): void
    {
        $this->mountCanSaveResource();
    }

    public function render()
    {
        $query = Auth::user()->savedResources()
            ->with('resource')
            ->join('resources', 'saved_resources.resource_id', '=', 'resources.id')
            ->select('saved_resources.*');

        if ($this->search) {
            $query->where('resources.title', 'like', '%' . $this->search . '%', 'and');
        }

        if ($this->selectedType) {
            $query->where('resources.resource_type', '=', $this->selectedType, 'and');
        }

        $resources = $query->latest('saved_resources.created_at')
            ->paginate(12)
            ->through(fn ($saved) => $saved->resource);

        return view('livewire.dashboard.saved-resources', [
            'resources' => $resources,
            'resourceTypes' => \App\Enums\ResourceType::cases(),
        ]);
    }
}
