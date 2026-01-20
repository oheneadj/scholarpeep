<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Schemas;
use Filament\Forms\Set;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;

use App\Models\AffiliateTool;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Toggle;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use App\Filament\Resources\AffiliateToolResource\Pages;
use App\Filament\Resources\AffiliateToolResource\Pages\EditAffiliateTool;
use App\Filament\Resources\AffiliateToolResource\Pages\ListAffiliateTools;
use App\Filament\Resources\AffiliateToolResource\Pages\CreateAffiliateTool;


class AffiliateToolResource extends Resource
{
    protected static ?string $model = AffiliateTool::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                
                TextInput::make('url')
                    ->label('Affiliate URL')
                    ->url()
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                    
                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
                    
                FileUpload::make('icon')
                    ->image()
                    ->directory('affiliate-icons')
                    ->visibility('public'),
                    
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                    
                Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('icon'),
                
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('url')
                    ->limit(30)
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->url(fn ($record) => $record->url, true),
                    
                ToggleColumn::make('is_active'),
                
                TextColumn::make('sort_order')
                    ->sortable(),

                TextColumn::make('clicks_count')
                    ->counts('clicks')
                    ->label('Clicks'),
            ])
            ->filters([
                //
            ])
            ->actions([
               EditAction::make(),
               DeleteAction::make(),
            ])
            ->bulkActions([
               BulkActionGroup::make([
                   DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAffiliateTools::route('/'),
            'create' => Pages\CreateAffiliateTool::route('/create'),
            'edit' => Pages\EditAffiliateTool::route('/{record}/edit'),
        ];
    }
}
