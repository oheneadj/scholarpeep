<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.frontend')]
class ToolsIndex extends Component
{
    public function render()
    {
        $tools = \App\Models\AffiliateTool::where('is_active', '=', true)
            ->orderBy('sort_order')
            ->get();

        app(\App\Services\MetaService::class)->setMeta(
            title: app(\App\Settings\SeoSettings::class)->tools_title ?? 'Affiliate Tools & Resources - Scholarpeep',
            description: app(\App\Settings\SeoSettings::class)->tools_description ?? 'Essential tools and services for students: language tests, visa assistance, travel insurance, and more.'
        );

        return view('livewire.pages.tools-index', [
            'tools' => $tools
        ]);
    }
}
