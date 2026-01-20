<?php

namespace App\Livewire\Pages;

use App\Models\Resource;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\ResourceView;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class ResourceShow extends Component
{
    public Resource $resource;

    public function mount(Resource $resource)
    {
        $this->resource = $resource;

        if (! $this->resource->is_active || ! $this->resource->is_published) {
            abort(404);
        }

        $this->recordView();
    }

    protected function recordView()
    {
        // Simple view counting, prevent duplicate counts in same session if needed, 
        // but for now just increment on visit
        $this->resource->increment('views_count', 1);

        // Optional: Detailed tracking
        if (auth()->check()) {
            ResourceView::firstOrCreate([
                'resource_id' => $this->resource->id,
                'user_id' => auth()->id(),
            ], [
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.pages.resource-show')
            ->layoutData([
                'meta_title' => $this->resource->meta_title ?? $this->resource->title,
                'meta_description' => $this->resource->meta_description ?? Str::limit($this->resource->description, 160),
                'og_image' => $this->resource->featured_image ? asset('storage/' . $this->resource->featured_image) : null,
            ]);
    }
}
