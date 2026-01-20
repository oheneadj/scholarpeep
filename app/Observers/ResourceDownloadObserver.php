<?php

namespace App\Observers;

use App\Models\ResourceDownload;
use App\Services\PointService;
use App\Services\BadgeService;

class ResourceDownloadObserver
{
    protected PointService $pointService;
    protected BadgeService $badgeService;

    public function __construct(PointService $pointService, BadgeService $badgeService)
    {
        $this->pointService = $pointService;
        $this->badgeService = $badgeService;
    }

    /**
     * Handle the ResourceDownload "created" event.
     */
    public function created(ResourceDownload $download): void
    {
        $user = $download->user;
        
        if (!$user) {
            return;
        }

        $this->pointService->awardPoints(
            $user,
            'resource_downloaded',
            $download,
            'Downloaded resource: ' . $download->resource->title
        );

        // Check and award badges
        $this->badgeService->checkAndAwardBadges($user);
    }
}
