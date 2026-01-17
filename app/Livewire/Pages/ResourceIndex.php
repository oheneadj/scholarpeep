<?php

namespace App\Livewire\Pages;

use App\Models\Resource;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use App\Models\SavedResource;

#[Layout('layouts.frontend')]
class ResourceIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedType = '';
    public $showFilters = false;
    public $savedResourceIds = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedType' => ['except' => '', 'as' => 'type'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedType()
    {
        $this->resetPage();
    }

    public function filterByType($type)
    {
        $this->selectedType = $this->selectedType === $type ? '' : $type;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'selectedType']);
        $this->resetPage();
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function toggleSave($resourceId)
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        $user = Auth::user();
        $key = 'save-resource:'.$user->id;

        if (RateLimiter::tooManyAttempts($key, 10)) {
            $seconds = RateLimiter::availableIn($key);
            $this->dispatch('notify', message: "Too many requests. Please wait $seconds seconds.");
            return;
        }

        RateLimiter::hit($key);

        $saved = SavedResource::where('user_id', $user->id)
            ->where('resource_id', $resourceId)
            ->first();

        if ($saved) {
            $saved->delete();
            $this->dispatch('notify', message: 'Resource removed from saved.');
        } else {
            SavedResource::create([
                'user_id' => $user->id,
                'resource_id' => $resourceId,
            ]);
            $this->dispatch('notify', message: 'Resource saved successfully!');
        }
    }

    public function getResourcesProperty()
    {
        return Resource::active()
            ->search($this->search)
            ->byType($this->selectedType)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
    }

    public function render()
    {
        if (Auth::check()) {
            $this->savedResourceIds = SavedResource::where('user_id', Auth::id())
                ->pluck('resource_id')
                ->toArray();
        }

        return view('livewire.pages.resource-index', [
            'resources' => $this->resources,
            'resourceTypes' => ['guide', 'template', 'tool', 'video', 'article', 'calculator'],
        ]);
    }
}
