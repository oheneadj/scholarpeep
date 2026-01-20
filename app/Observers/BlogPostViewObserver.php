<?php

namespace App\Observers;

use App\Models\BlogPostView;
use App\Services\PointService;
use App\Services\BadgeService;

class BlogPostViewObserver
{
    protected PointService $pointService;
    protected BadgeService $badgeService;

    public function __construct(PointService $pointService, BadgeService $badgeService)
    {
        $this->pointService = $pointService;
        $this->badgeService = $badgeService;
    }

    /**
     * Handle the BlogPostView "created" event.
     */
    public function created(BlogPostView $view): void
    {
        $user = $view->user;
        
        if (!$user) {
            return;
        }

        // Only award points once per blog post per user
        $existingViews = BlogPostView::where('user_id', $user->id)
            ->where('blog_post_id', $view->blog_post_id)
            ->count();

        if ($existingViews === 1) {
            $this->pointService->awardPoints(
                $user,
                'blog_post_read',
                $view,
                'Read blog post: ' . $view->blogPost->title
            );

            // Check and award badges
            $this->badgeService->checkAndAwardBadges($user);
        }
    }
}
