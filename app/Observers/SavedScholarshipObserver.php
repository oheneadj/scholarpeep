<?php

namespace App\Observers;

use App\Models\SavedScholarship;
use App\Services\PointService;
use App\Services\BadgeService;

class SavedScholarshipObserver
{
    protected PointService $pointService;
    protected BadgeService $badgeService;

    public function __construct(PointService $pointService, BadgeService $badgeService)
    {
        $this->pointService = $pointService;
        $this->badgeService = $badgeService;
    }

    /**
     * Handle the SavedScholarship "created" event.
     */
    public function created(SavedScholarship $savedScholarship): void
    {
        $user = $savedScholarship->user;
        
        if (!$user) {
            return;
        }

        // Check if this is the user's first saved scholarship
        $isFirst = SavedScholarship::where('user_id', $user->id)->count() === 1;

        if ($isFirst) {
            $this->pointService->awardPoints(
                $user,
                'first_scholarship_saved',
                $savedScholarship,
                'Saved your first scholarship: ' . $savedScholarship->scholarship->title
            );
        } else {
            $this->pointService->awardPoints(
                $user,
                'scholarship_saved',
                $savedScholarship,
                'Saved scholarship: ' . $savedScholarship->scholarship->title
            );
        }

        // Check and award badges
        $this->badgeService->checkAndAwardBadges($user);
    }
}
