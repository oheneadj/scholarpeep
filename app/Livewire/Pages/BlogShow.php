<?php

namespace App\Livewire\Pages;

use App\Models\BlogPost;
use Livewire\Component;
use Illuminate\Support\Str;

use Livewire\Attributes\Layout;

#[Layout('layouts.frontend')]
class BlogShow extends Component
{
    public BlogPost $post;

    public function mount(BlogPost $post)
    {
        // Check if published
        if (!$post->is_published || $post->published_at > now()) {
            abort(404);
        }

        $this->post = $post;
        
        // Increment views
        $this->post->increment('views_count', 1);

        // Record detailed view for analytics
        \App\Models\BlogPostView::create([
            'blog_post_id' => $post->id,
            'user_id' => auth()->id()?? null,
            'ip_address' => request()->ip(),    
            'user_agent' => request()->userAgent(),
            'referrer' => request()->header('referer'),
        ]);
    }
    public function render()
    {
        // Popular Posts for Sidebar
        $popularPosts = BlogPost::published()
            ->where('id', '!=', $this->post->id)
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        // Related Posts ("Read Next")
        $relatedPosts = BlogPost::published()
            ->where('id', '!=', $this->post->id)
            ->latest()
            ->take(3)
            ->get();

        // Featured Posts for Sidebar Slider
        $featuredPosts = BlogPost::published()
            ->with('author')
            ->where('is_featured', true)
            ->where('id', '!=', $this->post->id)
            ->latest()
            ->take(5)
            ->get();
            
        // Fallback if no featured posts
        if ($featuredPosts->isEmpty()) {
            $featuredPosts = BlogPost::published()
                ->where('id', '!=', $this->post->id)
                ->inRandomOrder()
                ->take(5)
                ->get();
        }

        // Featured Scholarships for Sidebar
        $featuredScholarships = \App\Models\Scholarship::where('status', \App\Enums\ScholarshipStatus::ACTIVE)
            ->where('sponsorship_tier', \App\Enums\SponsorshipTier::FEATURED)
            ->latest()
            ->take(3)
            ->get();

        $topics = \App\Models\ScholarshipType::all();



        app(\App\Services\MetaService::class)->setMeta(
            title: $this->post->meta_title ?? $this->post->title,
            description: $this->post->meta_description ?? Str::limit(strip_tags($this->post->content), 160),
            image: $this->post->featured_image ? \Illuminate\Support\Facades\Storage::url($this->post->featured_image) : null,
            type: 'article'
        );

        return view('livewire.pages.blog-show', [
            'popularPosts' => $popularPosts,
            'relatedPosts' => $relatedPosts,
            'featuredPosts' => $featuredPosts,
            'featuredScholarships' => $featuredScholarships,
            'topics' => $topics,
        ]);
    }
}
