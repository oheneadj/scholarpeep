<?php

namespace App\Livewire\Pages;

use App\Models\Faq;
use Livewire\Component;

class FaqIndex extends Component
{
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function render()
    {
        $faqs = Faq::query()
            ->where('is_published', true)
            ->when($this->search, function ($query) {
                $query->where('question', 'like', '%'.$this->search.'%')
                      ->orWhere('answer', 'like', '%'.$this->search.'%');
            })
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by category if needed, or just list them. 
        // For a simple search, listing might be better, or grouped.
        // Let's pass them as a collection and let the view handle it.
        // If search is active, flat list is better. If not, grouped by category is nice.
        
        $groupedFaqs = $this->search ? null : $faqs->groupBy('category');

        return view('livewire.pages.faq-index', [
            'faqs' => $faqs,
            'groupedFaqs' => $groupedFaqs,
        ])->layout('layouts.frontend')->layoutData([
            'title' => app(\App\Settings\SeoSettings::class)->faq_title ?? 'Frequently Asked Questions - Scholarpeep',
            'description' => app(\App\Settings\SeoSettings::class)->faq_description ?? 'Get answers to common questions about scholarships, financial aid, and calculating your chances of winning.',
        ]);
    }
}
