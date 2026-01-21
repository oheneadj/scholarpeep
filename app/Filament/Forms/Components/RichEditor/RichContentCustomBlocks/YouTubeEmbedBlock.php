<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;

class YouTubeEmbedBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'you_tube_embed';
    }

    public static function getLabel(): string
    {
        return 'You tube embed';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the you tube embed block')
            ->schema([
                //
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.you-tube-embed.preview', [
            //
        ])->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.you-tube-embed.index', [
            //
        ])->render();
    }
}
