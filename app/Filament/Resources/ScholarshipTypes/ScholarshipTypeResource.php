<?php

namespace App\Filament\Resources\ScholarshipTypes;

use App\Filament\Resources\ScholarshipTypes\Pages\ListScholarshipTypes;
use App\Filament\Resources\ScholarshipTypes\Schemas\ScholarshipTypeForm;
use App\Filament\Resources\ScholarshipTypes\Tables\ScholarshipTypesTable;
use App\Models\ScholarshipType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ScholarshipTypeResource extends Resource
{
    protected static string|\UnitEnum|null $navigationGroup = 'Reference Data';

    protected static ?string $model = ScholarshipType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    public static function form(Schema $schema): Schema
    {
        return ScholarshipTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ScholarshipTypesTable::configure($table);
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
            'index' => ListScholarshipTypes::route('/'),

        ];
    }
}
