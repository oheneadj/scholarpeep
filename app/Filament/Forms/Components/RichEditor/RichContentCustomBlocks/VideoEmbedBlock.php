<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;

class VideoEmbedBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'video_embed';
    }

    public static function getLabel(): string
    {
        return 'Video embed';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->icon('heroicon-o-video-camera')
            ->modalDescription('Configure the video embed block')
            ->schema([
                \Filament\Forms\Components\TextInput::make('url')
                    ->label('Video URL')
                    ->required()
                    ->url()
                    ->helperText('Supports YouTube and Vimeo URLs (e.g., https://www.youtube.com/watch?v=...)')
                    ->placeholder('https://www.youtube.com/watch?v=...'),
                \Filament\Forms\Components\TextInput::make('height')
                    ->label('Height (px)')
                    ->numeric()
                    ->default(400),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.video-embed.preview', [
            'url' => static::getEmbedUrl($config['url'] ?? null),
            'height' => $config['height'] ?? 400,
        ])->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.video-embed.index', [
            'url' => static::getEmbedUrl($config['url'] ?? null),
            'height' => $config['height'] ?? 400,
        ])->render();
    }

    protected static function getEmbedUrl(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        // YouTube: watch?v=ID -> embed/ID
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches)) {
            return "https://www.youtube.com/embed/{$matches[1]}";
        }

        // Vimeo: vimeo.com/ID -> player.vimeo.com/video/ID
        if (preg_match('/(?:vimeo\.com\/)([0-9]+)/', $url, $matches)) {
            return "https://player.vimeo.com/video/{$matches[1]}";
        }

        return $url;
    }
}
