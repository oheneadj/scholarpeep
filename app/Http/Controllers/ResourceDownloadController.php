<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResourceDownloadController extends Controller
{
    /**
     * Handle the resource download.
     */
    public function __invoke(Request $request, Resource $resource)
    {
        // 1. Ensure the resource has a file
        if (!$resource->file_path || !Storage::exists($resource->file_path)) {
            abort(404, 'File not found.');
        }

        // 2. Record the download for analytics
        ResourceDownload::create([
            'resource_id' => $resource->id,
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'downloaded_at' => now(),
        ]);

        // 3. Increment counters on the model
        $resource->increment('downloads_count', 1);

        // 4. Return the file download
        return Storage::download($resource->file_path, $resource->title . '.' . pathinfo($resource->file_path, PATHINFO_EXTENSION));
    }
}
