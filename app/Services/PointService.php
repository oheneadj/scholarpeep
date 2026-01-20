<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserPoint;
use App\Models\PointTransaction;
use App\Models\PointRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PointService
{
    /**
     * Award points to a user for a specific action
     */
    public function awardPoints(
        User $user,
        string $actionType,
        ?Model $reference = null,
        ?string $customDescription = null
    ): ?PointTransaction {
        $rule = PointRule::getByAction($actionType);
        
        if (!$rule) {
            return null;
        }

        // Check daily limit if applicable
        if ($rule->max_per_day && !$this->checkDailyLimit($user, $actionType, $rule->max_per_day)) {
            return null;
        }

        return DB::transaction(function () use ($user, $rule, $reference, $customDescription) {
            // Get or create user points record
            $userPoints = UserPoint::firstOrCreate(
                ['user_id' => $user->id],
                ['total_points' => 0, 'lifetime_points' => 0, 'current_level' => 1]
            );

            // Create transaction
            $transaction = PointTransaction::create([
                'user_id' => $user->id,
                'points' => $rule->points,
                'action_type' => $rule->action_type,
                'description' => $customDescription ?? $rule->description,
                'reference_id' => $reference?->id,
                'reference_type' => $reference ? get_class($reference) : null,
            ]);

            // Update user points
            $userPoints->total_points += $rule->points;
            $userPoints->lifetime_points += $rule->points;
            $userPoints->current_level = $userPoints->calculateLevel();
            $userPoints->save();

            return $transaction;
        });
    }

    /**
     * Deduct points from a user
     */
    public function deductPoints(
        User $user,
        int $points,
        string $reason,
        ?Model $reference = null
    ): ?PointTransaction {
        $userPoints = UserPoint::where('user_id', '=', $user->id, 'and')->first();

        if (!$userPoints || $userPoints->total_points < $points) {
            return null; // Not enough points
        }

        return DB::transaction(function () use ($user, $userPoints, $points, $reason, $reference) {
            $transaction = PointTransaction::create([
                'user_id' => $user->id,
                'points' => -$points,
                'action_type' => 'deduction',
                'description' => $reason,
                'reference_id' => $reference?->id,
                'reference_type' => $reference ? get_class($reference) : null,
            ]);

            $userPoints->total_points -= $points;
            $userPoints->current_level = $userPoints->calculateLevel();
            $userPoints->save();

            return $transaction;
        });
    }

    /**
     * Check if user has reached daily limit for an action
     */
    protected function checkDailyLimit(User $user, string $actionType, int $maxPerDay): bool
    {
        $todayCount = PointTransaction::where('user_id', '=', $user->id, 'and')
            ->where('action_type', '=', $actionType, 'and')
            ->whereDate('created_at', today())
            ->count();

        return $todayCount < $maxPerDay;
    }

    /**
     * Get user's point summary
     */
    public function getUserPointsSummary(User $user): array
    {
        $userPoints = UserPoint::firstOrCreate(
            ['user_id' => $user->id],
            ['total_points' => 0, 'lifetime_points' => 0, 'current_level' => 1]
        );

        return [
            'total_points' => $userPoints->total_points,
            'lifetime_points' => $userPoints->lifetime_points,
            'current_level' => $userPoints->current_level,
            'points_to_next_level' => $userPoints->pointsToNextLevel(),
            'progress_percentage' => $userPoints->progressToNextLevel(),
        ];
    }

    /**
     * Get recent transactions for a user
     */
    public function getRecentTransactions(User $user, int $limit = 10)
    {
        return PointTransaction::where('user_id', '=', $user->id, 'and')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Award daily login bonus
     */
    public function awardDailyLogin(User $user): ?PointTransaction
    {
        $lastLogin = $user->last_login_date;
        $today = today();

        // Already awarded today?
        if ($lastLogin && $lastLogin->isToday()) {
            return null;
        }

        // Update login streak
        if ($lastLogin && $lastLogin->isYesterday()) {
            $user->login_streak++;
        } else {
            $user->login_streak = 1;
        }

        $user->last_login_date = $today;
        $user->save();

        // Award standard daily points
        $transaction = $this->awardPoints($user, 'daily_login');

        // Check for streak milestones
        $this->checkStreakMilestones($user);

        return $transaction;
    }

    /**
     * Check and award points for streak milestones
     */
    protected function checkStreakMilestones(User $user): void
    {
        $streak = $user->login_streak;
        $milestones = [
            30 => ['points' => 500, 'desc' => '30-day login streak milestone!'],
            14 => ['points' => 200, 'desc' => '14-day login streak milestone!'],
            7  => ['points' => 100, 'desc' => '7-day login streak milestone!'],
        ];

        foreach ($milestones as $days => $data) {
            if ($streak === $days) {
                // Award points manually since we might not have a rule for this specific milestone
                // Or we can create a generic 'streak_bonus' and pass custom points
                $this->awardPoints($user, 'streak_bonus', null, $data['desc']);
                break; // Only award the highest reached milestone today
            }
        }
    }
}
