<?php

namespace App\Filament\Resources\Scholarships\Schemas;

use Filament\Schemas\Schema;

class ScholarshipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Tabs::make('Scholarship Details')
                    ->tabs([
                        \Filament\Schemas\Components\Tabs\Tab::make('Basic Information')
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                \Filament\Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                \Filament\Forms\Components\TextInput::make('provider_name')
                                    ->required()
                                    ->maxLength(255),
                                \Filament\Forms\Components\FileUpload::make('provider_logo')
                                    ->image()
                                    ->directory('provider-logos'),
                                \Filament\Forms\Components\FileUpload::make('featured_image')
                                    ->image()
                                    ->directory('scholarship-images')
                                    ->label('Featured Image')
                                    ->helperText('Upload a featured image for this scholarship (recommended: 1200x600px)'),
                                \Filament\Forms\Components\RichEditor::make('description')
                                    ->required()
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\RichEditor::make('eligibility_criteria')
                                    ->required()
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\TextInput::make('award_amount')
                                    ->numeric(),
                                \Filament\Forms\Components\TextInput::make('currency')
                                    ->default('USD')
                                    ->maxLength(10),
                                \Filament\Forms\Components\TextInput::make('application_url')
                                    ->url()
                                    ->maxLength(255),
                                \Filament\Forms\Components\DatePicker::make('primary_deadline'),
                                \Filament\Forms\Components\Toggle::make('is_rolling')
                                    ->label('Rolling Deadline'),
                                \Filament\Forms\Components\Select::make('status')
                                    ->options(\App\Enums\ScholarshipStatus::class)
                                    ->required()
                                    ->default(\App\Enums\ScholarshipStatus::ACTIVE),
                            ])->columns(2),

                        \Filament\Schemas\Components\Tabs\Tab::make('Categorization')
                            ->schema([
                                \Filament\Forms\Components\Select::make('countries')
                                    ->multiple()
                                    ->relationship('countries', 'name')
                                    ->preload()
                                    ->searchable(),
                                \Filament\Forms\Components\Select::make('educationLevels')
                                    ->multiple()
                                    ->relationship('educationLevels', 'name')
                                    ->preload(),
                                \Filament\Forms\Components\Select::make('fieldsOfStudy')
                                    ->multiple()
                                    ->relationship('fieldsOfStudy', 'name')
                                    ->preload()
                                    ->searchable(),
                                \Filament\Forms\Components\Select::make('scholarshipTypes')
                                    ->multiple()
                                    ->relationship('scholarshipTypes', 'name')
                                    ->preload(),
                            ])->columns(2),

                        \Filament\Schemas\Components\Tabs\Tab::make('Deadlines')
                            ->schema([
                                \Filament\Forms\Components\Repeater::make('deadlines')
                                    ->relationship('deadlines')
                                    ->schema([
                                        \Filament\Forms\Components\Select::make('type')
                                            ->options(\App\Enums\DeadlineType::class)
                                            ->required(),
                                        \Filament\Forms\Components\DatePicker::make('date')
                                            ->required(),
                                        \Filament\Forms\Components\TextInput::make('description')
                                            ->maxLength(255),
                                    ])
                                    ->columns(3)
                                    ->columnSpanFull(),
                            ]),

                        \Filament\Schemas\Components\Tabs\Tab::make('Requirements')
                            ->schema([
                                \Filament\Forms\Components\Repeater::make('requirements')
                                    ->relationship('requirements')
                                    ->schema([
                                        \Filament\Forms\Components\Select::make('type')
                                            ->options(\App\Enums\RequirementType::class)
                                            ->required(),
                                        \Filament\Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(255),
                                        \Filament\Forms\Components\Textarea::make('description')
                                            ->maxLength(1000),
                                        \Filament\Forms\Components\Toggle::make('is_required')
                                            ->default(true),
                                        \Filament\Forms\Components\TextInput::make('order')
                                            ->numeric()
                                            ->default(0),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull()
                                    ->reorderable()
                                    ->orderColumn('order'),
                            ]),

                        \Filament\Schemas\Components\Tabs\Tab::make('Sponsorship')
                            ->schema([
                                \Filament\Forms\Components\Select::make('sponsorship_tier')
                                    ->options(\App\Enums\SponsorshipTier::class)
                                    ->required()
                                    ->default(\App\Enums\SponsorshipTier::STANDARD),
                                \Filament\Forms\Components\DatePicker::make('sponsorship_start_date'),
                                \Filament\Forms\Components\DatePicker::make('sponsorship_end_date'),
                                \Filament\Forms\Components\Textarea::make('internal_notes')
                                    ->columnSpanFull(),
                            ])->columns(3),

                        \Filament\Schemas\Components\Tabs\Tab::make('SEO')
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('meta_title')
                                    ->maxLength(60)
                                    ->hint(fn($state) => strlen($state) . '/60 chars'),
                                \Filament\Forms\Components\Textarea::make('meta_description')
                                    ->maxLength(160)
                                    ->hint(fn($state) => strlen($state) . '/160 chars'),
                            ]),
                    ]),
            ])->columns(1);
    }
}
