<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdClickController extends Controller
{
    public function track(Ad $ad)
    {
        // Track the click with user if authenticated
        $userId = auth()->check() ? auth()->id() : null;
        $ad->trackClick($userId);

        // Redirect to the ad's target URL
        return redirect()->away($ad->url);
    }

    public function trackImpression(Ad $ad)
    {
        $ad->trackImpression();
        
        return response()->json(['success' => true]);
    }
}
