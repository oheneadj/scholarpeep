<?php

namespace App\Livewire\Pages;

use App\Models\BlogPost;
use Livewire\Component;
use Livewire\WithPagination;

class BlogIndex extends Component
{
    use WithPagination;

    public $selectedCategory = null; // Currently using 'tag' behavior as distinct categories might not exist yet
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => null],
    ];

    public function setCategory($category)
    {
        $this->selectedCategory = $category === $this->selectedCategory ? null : $category;
        $this->resetPage();
    }

    public function render()
    {
        $query = BlogPost::published()
            ->with('author')
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $this->search . '%');
            });

        // Featured Posts (Slider) - Take top 5
        $featuredPosts = BlogPost::published()->latest()->take(5)->get();
        
        // Exclude featured posts from main listing if we are not searching/filtering
        if (!$this->search && !$this->selectedCategory) {
            $featuredIds = $featuredPosts->pluck('id')->toArray();
            $query->whereNotIn('id', $featuredIds);
        }

        $posts = $query->latest()->paginate(9);
        
        // Popular Posts for Sidebar (Most views)
        $popularPosts = BlogPost::published()->orderBy('views_count', 'desc')->take(4)->get();

        // Categories (Mocking based on typical content, or could fetch tags if implemented)
        $categories = [
            'Scholarships', 'Study Abroad', 'Student Life', 'Career Tips', 'Financial Aid'
        ];

        return view('livewire.pages.blog-index', [
            'featuredPosts' => $featuredPosts,
            'posts' => $posts,
            'popularPosts' => $popularPosts,
            'categories' => $categories,
        ])->layout('layouts.frontend')->layoutData([
            'title' => app(\App\Settings\SeoSettings::class)->blog_title ?? 'Scholarship Tips & Guides - Scholarpeep Blog',
            'description' => app(\App\Settings\SeoSettings::class)->blog_description ?? 'Expert advice, success stories, and guides on how to win scholarships and study abroad.',
        ]);
    }
}
