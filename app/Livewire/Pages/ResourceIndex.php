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
    use \App\Livewire\Traits\CanSaveResource;

    public $search = '';
    public $selectedType = '';
    public $showFilters = false;

    public function mount()
    {
        $this->mountCanSaveResource();
    }

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

        return view('livewire.pages.resource-index', [
            'resources' => $this->resources,
            'resourceTypes' => ['guide', 'template', 'tool', 'video', 'article', 'calculator'],
        ])->layoutData([
            'title' => app(\App\Settings\SeoSettings::class)->resources_title ?? 'Student Resources & Tools - Scholarpeep',
            'description' => app(\App\Settings\SeoSettings::class)->resources_description ?? 'Free templates, guides, and tools to help you craft winning scholarship applications.',
        ]);
    }
}
