<?php

namespace App\Services;

use App\Models\User;
use App\Models\Badge;
use App\Models\UserBadge;
use App\Models\SavedScholarship;
use App\Models\ResourceDownload;
use Illuminate\Support\Facades\DB;

class BadgeService
{
    /**
     * Check and award all applicable badges for a user
     */
    public function checkAndAwardBadges(User $user): array
    {
        $newlyEarned = [];
        $badges = Badge::active()->get();

        foreach ($badges as $badge) {
            $currentProgress = $this->calculateProgress($user, $badge);
            
            // Get or create user badge record
            $userBadge = UserBadge::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'badge_id' => $badge->id,
                ],
                [
                    'progress' => 0,
                    'earned_at' => null,
                ]
            );

            // Update progress
            if ($userBadge->progress != $currentProgress) {
                $userBadge->progress = $currentProgress;
                $userBadge->save();
            }

            // Award badge if criteria met and not already earned
            if ($currentProgress >= $badge->criteria_value && !$userBadge->isEarned()) {
                $userBadge->earned_at = now();
                $userBadge->save();
                $newlyEarned[] = $badge;
            }
        }

        return $newlyEarned;
    }

    /**
     * Calculate current progress for a badge
     */
    protected function calculateProgress(User $user, Badge $badge): int
    {
        return match($badge->criteria_type) {
            'saved_scholarships_count' => SavedScholarship::where('user_id', $user->id)->count(),
            'applications_count' => $user->applicationDocuments()->count(), // Proxy for applications
            'resources_downloaded_count' => ResourceDownload::where('user_id', $user->id)->count(),
            'login_streak' => $user->login_streak ?? 0,
            'total_points' => $user->points?->total_points ?? 0,
            default => 0,
        };
    }

    /**
     * Get badge progress for a user
     */
    public function getBadgeProgress(User $user, ?string $category = null): array
    {
        $query = Badge::active();
        
        if ($category) {
            $query->where('category', $category);
        }

        $badges = $query->orderBy('category')->orderBy('sort_order')->get();
        $progress = [];

        foreach ($badges as $badge) {
            $userBadge = UserBadge::where('user_id', $user->id)
                ->where('badge_id', $badge->id)
                ->first();

            $currentProgress = $this->calculateProgress($user, $badge);

            $progress[] = [
                'badge' => $badge,
                'current_progress' => $currentProgress,
                'required' => $badge->criteria_value,
                'percentage' => min(100, ($currentProgress / $badge->criteria_value) * 100),
                'is_earned' => $userBadge?->isEarned() ?? false,
                'earned_at' => $userBadge?->earned_at,
            ];
        }

        return $progress;
    }

    /**
     * Get earned badges for a user
     */
    public function getEarnedBadges(User $user)
    {
        return $user->earnedBadges()
            ->orderBy('user_badges.earned_at', 'desc')
            ->get();
    }

    /**
     * Get badge categories with counts
     */
    public function getBadgeCategories(User $user): array
    {
        $categories = Badge::active()
            ->select('category')
            ->distinct()
            ->pluck('category');

        $result = [];
        foreach ($categories as $category) {
            $totalBadges = Badge::active()->where('category', $category)->count();
            $earnedBadges = $user->earnedBadges()->where('category', $category)->count();

            $result[] = [
                'category' => $category,
                'total' => $totalBadges,
                'earned' => $earnedBadges,
                'percentage' => $totalBadges > 0 ? ($earnedBadges / $totalBadges) * 100 : 0,
            ];
        }

        return $result;
    }
}
