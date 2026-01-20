<?php

namespace App\Filament\Resources\BlogPosts\Pages;

use App\Filament\Resources\BlogPosts\BlogPostResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBlogPost extends EditRecord
{
    protected static string $resource = BlogPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            \Filament\Actions\Action::make('preview')
                ->url(fn () => route('blog.show', $this->record->slug))
                ->openUrlInNewTab()
                ->icon('heroicon-o-eye'),
        ];
    }
}
