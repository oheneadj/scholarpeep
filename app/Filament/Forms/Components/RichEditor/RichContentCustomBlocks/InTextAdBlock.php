<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;

class InTextAdBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'in_text_ad';
    }

    public static function getLabel(): string
    {
        return 'In text ad';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->icon('heroicon-o-megaphone')
            ->modalDescription('Insert an advertisement into the content. Leave blank to show a random In-Text ad.')
            ->schema([
                \Filament\Forms\Components\Select::make('ad_id')
                    ->label('Specific Ad (Optional)')
                    ->options(\App\Models\Ad::position(\App\Enums\AdPosition::IN_TEXT)->pluck('title', 'id'))
                    ->searchable()
                    ->placeholder('Random In-Text Ad'),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        $adId = $config['ad_id'] ?? null;
        $ad = $adId ? \App\Models\Ad::find($adId) : null;

        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.in-text-ad.preview', [
            'ad' => $ad,
        ])->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        $adId = $config['ad_id'] ?? null;
        
        // If a specific ad is selected, pass it. Otherwise pass null to let the view/component pick a random one.
        $ad = $adId ? \App\Models\Ad::find($adId) : null;

        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.in-text-ad.index', [
            'ad' => $ad,
        ])->render();
    }
}
