<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\PointRule;
use App\Services\PointService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class PointServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PointService $pointService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pointService = app(PointService::class);
        
        // Ensure rules exist (daily_login is seeded with 5 in migration)
        PointRule::updateOrCreate(['action_type' => 'daily_login'], [
            'points' => 5, 
            'description' => 'Daily login bonus', 
            'is_active' => true
        ]);
        PointRule::updateOrCreate(['action_type' => 'streak_bonus'], [
            'points' => 100, 
            'description' => 'Streak milestone bonus', 
            'is_active' => true
        ]);
    }

    public function test_it_awards_bonus_on_7_day_streak()
    {
        $user = User::factory()->create([
            'login_streak' => 6,
            'last_login_date' => Carbon::yesterday(),
        ]);

        $this->pointService->awardDailyLogin($user);

        $user->refresh();
        $this->assertEquals(7, $user->login_streak);
        
        // Should have 1 daily_login (5) + 1 streak_bonus (100) = 105 points
        $this->assertEquals(105, $user->points->total_points);
        
        $this->assertDatabaseHas('point_transactions', [
            'user_id' => $user->id,
            'action_type' => 'streak_bonus',
        ]);
    }

    public function test_it_does_not_award_bonus_on_regular_day()
    {
        $user = User::factory()->create([
            'login_streak' => 2,
            'last_login_date' => Carbon::yesterday(),
        ]);

        $this->pointService->awardDailyLogin($user);

        $user->refresh();
        $this->assertEquals(3, $user->login_streak);
        
        // Should have 1 daily_login (5)
        $this->assertEquals(5, $user->points->total_points);
        
        $this->assertDatabaseMissing('point_transactions', [
            'user_id' => $user->id,
            'action_type' => 'streak_bonus',
        ]);
    }
}
