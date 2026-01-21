<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Utilities\Set;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Main Content')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->columnSpanFull()
                            ->placeholder('Enter blog post title')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state, $record) {
                                $slug = \Illuminate\Support\Str::slug($state);
                                $originalSlug = $slug;
                                $counter = 1;
                                
                                // Check if slug exists and increment until unique
                                while (\App\Models\BlogPost::where('slug', $slug)
                                    ->when($record, fn($query) => $query->where('id', '!=', $record->id))
                                    ->exists()) {
                                    $slug = $originalSlug . '-' . $counter;
                                    $counter++;
                                }
                                
                                $set('slug', $slug);
                                $set('meta_title', $state);
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->columnSpanFull()
                            ->unique(ignoreRecord: true),
                        RichEditor::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                if ($state) {
                                    // Strip HTML tags and get plain text
                                    $plainText = strip_tags($state);
                                    // Generate excerpt (first 160 characters)
                                    $excerpt = Str::limit($plainText, 160);
                                    $set('excerpt', $excerpt);
                                    $set('meta_description', $excerpt);
                                }
                            })
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'customBlocks',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'undo',
                            ])
                            ->customBlocks([
                                \App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\VideoEmbedBlock::class,
                                \App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\InTextAdBlock::class,
                            ]),
                        Textarea::make('excerpt')
                            ->columnSpanFull()
                            ->helperText('Auto-generated from content. You can edit if needed.'),
                    ])->columns(2),

                    Group::make([
                        Section::make('Media & Publishing')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->image()
                            ->disk('public')
                            ->directory('blog'),
                        Select::make('author_id')
                            ->relationship('author', 'name')
                            ->default(auth()->id())
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('category')
                            ->options([
                                'Scholarships' => 'Scholarships',
                                'Study Abroad' => 'Study Abroad',
                                'Student Life' => 'Student Life',
                                'Career Tips' => 'Career Tips',
                                'Financial Aid' => 'Financial Aid',
                            ])
                            ->searchable()
                            ->required(),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->helperText('Enable to make this post visible to the public')
                            ->required(),
                        DateTimePicker::make('published_at')
                            ->default(now()),
                    ])->columns(1),
                    
                        Section::make('SEO Metadata')
                        ->schema([
                            TextInput::make('meta_title')
                                ->helperText('Auto-generated from title. You can edit if needed.')
                                ->columnSpanFull(),
                            Textarea::make('meta_description')
                                ->helperText('Auto-generated from content. You can edit if needed.')
                                ->columnSpanFull(),
                        ])->collapsible(),
                    ]),

                

                
            ]);
    }
}
