<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceView;
use Illuminate\Http\Request;

class ResourceViewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Resource $resource)
    {
        // 1. Record the view
        ResourceView::create([
            'resource_id' => $resource->id,
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'viewed_at' => now(),
        ]);

        // 2. Increment the views count on the resource
        $resource->increment('views_count', 1);

        // 3. Redirect if it's an external link, otherwise go to index (fallback)
        if ($resource->external_url) {
            return redirect()->away($resource->external_url);
        }

        return redirect()->route('resources.index');
    }
}
