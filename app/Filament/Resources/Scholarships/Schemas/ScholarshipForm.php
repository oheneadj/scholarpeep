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
                                    ->placeholder('e.g. Gates Cambridge Scholarship')
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, $record) {
                                        $slug = \Illuminate\Support\Str::slug($state);
                                        $originalSlug = $slug;
                                        $counter = 1;
                                        
                                        // Check if slug exists and increment until unique
                                        while (\App\Models\Scholarship::where('slug', $slug)
                                            ->when($record, fn($query) => $query->where('id', '!=', $record->id))
                                            ->exists()) {
                                            $slug = $originalSlug . '-' . $counter;
                                            $counter++;
                                        }
                                        
                                        $set('slug', $slug);
                                        $set('meta_title', \Illuminate\Support\Str::limit($state, 60));
                                    }),
                                \Filament\Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->placeholder('e.g. gates-cambridge-scholarship')
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                \Filament\Forms\Components\TextInput::make('provider_name')
                                    ->required()
                                    ->placeholder('e.g. Bill & Melinda Gates Foundation')
                                    ->maxLength(255),
                                \Filament\Forms\Components\FileUpload::make('provider_logo')
                                    ->image()
                                    ->disk('public')
                                    ->directory('provider-logos'),
                                \Filament\Forms\Components\FileUpload::make('featured_image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('scholarship-images')
                                    ->label('Featured Image')
                                    ->helperText('Upload a featured image for this scholarship (recommended: 1200x600px)'),
                                \Filament\Forms\Components\RichEditor::make('description')
                                    ->required()
                                    ->placeholder('Detailed description of the scholarship...')
                                    ->columnSpanFull()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            // Strip HTML tags and get plain text
                                            $plainText = strip_tags($state);
                                            // Generate meta description (first 160 characters)
                                            $metaDescription = \Illuminate\Support\Str::limit($plainText, 160);
                                            $set('meta_description', $metaDescription);
                                        }
                                    }),
                                \Filament\Forms\Components\RichEditor::make('eligibility_criteria')
                                    ->required()
                                    ->placeholder('e.g. Must be a citizen of...')
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\TextInput::make('award_amount')
                                    ->placeholder('e.g. 50000')
                                    ->numeric(),
                                \Filament\Forms\Components\TextInput::make('currency')
                                    ->default('USD')
                                    ->placeholder('USD')
                                    ->maxLength(10),
                                \Filament\Forms\Components\TextInput::make('application_url')
                                    ->url()
                                    ->placeholder('https://gatescambridge.org/apply')
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
                                    ->hint(fn($state) => strlen($state) . '/60 chars')
                                    ->helperText('Auto-generated from title. You can edit if needed.'),
                                \Filament\Forms\Components\Textarea::make('meta_description')
                                    ->maxLength(160)
                                    ->hint(fn($state) => strlen($state) . '/160 chars')
                                    ->helperText('Auto-generated from description. You can edit if needed.'),
                            ]),
                    ]),
            ])->columns(1);
    }
}
