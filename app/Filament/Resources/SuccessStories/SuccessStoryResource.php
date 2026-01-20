<?php

namespace App\Filament\Resources\SuccessStories;

use App\Filament\Resources\SuccessStories\Pages\CreateSuccessStory;
use App\Filament\Resources\SuccessStories\Pages\EditSuccessStory;
use App\Filament\Resources\SuccessStories\Pages\ListSuccessStories;
use App\Filament\Resources\SuccessStories\Schemas\SuccessStoryForm;
use App\Filament\Resources\SuccessStories\Tables\SuccessStoriesTable;
use App\Models\SuccessStory;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SuccessStoryResource extends Resource
{
    protected static ?string $model = SuccessStory::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-sparkles';
    protected static \UnitEnum|string|null $navigationGroup = 'Content Management';

    public static function form(Schema $schema): Schema
    {
        return SuccessStoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SuccessStoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSuccessStories::route('/'),
            'create' => CreateSuccessStory::route('/create'),
            'edit' => EditSuccessStory::route('/{record}/edit'),
        ];
    }
}
