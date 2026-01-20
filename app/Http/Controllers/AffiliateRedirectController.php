<?php

namespace App\Http\Controllers;

use App\Models\AffiliateTool;
use Illuminate\Http\Request;

class AffiliateRedirectController extends Controller
{
    public function __invoke(Request $request, string $slug)
    {
        $tool = AffiliateTool::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Track the click
        $tool->clicks()->create([
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referrer' => $request->headers->get('referer'),
            'created_at' => now(),
        ]);

        return redirect()->away($tool->url);
    }
}
