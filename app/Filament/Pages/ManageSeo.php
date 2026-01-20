<?php

namespace App\Filament\Pages;


use Filament\Schemas\Schema;
use App\Settings\SeoSettings;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Tabs\Tab;

class ManageSeo extends SettingsPage
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-globe-alt';

    protected static \UnitEnum|string|null $navigationGroup = 'Settings';

    protected static ?string $title = 'SEO & Analytics';

    protected static ?int $navigationSort = 3;

    protected static string $settings = SeoSettings::class;

    public static function canAccess(): bool
    {
        return auth()->user()->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Components\Tabs::make('SEO')
                    ->tabs([
                        Tab::make('General')
                            ->schema([
                               TextInput::make('site_name')
                                    ->required()
                                    ->helperText('The name of the website used in title tags.'),
                               Textarea::make('site_description')
                                    ->rows(3)
                                    ->helperText('Default meta description for pages without specific content.'),
                               FileUpload::make('site_logo')
                                    ->image()
                                    ->directory('seo')
                                    ->visibility('public'),
                               FileUpload::make('og_image')
                                    ->label('Default Social Image (OG Image)')
                                    ->image()
                                    ->directory('seo')
                                    ->visibility('public')
                                    ->helperText('Used when a page doesn\'t have a specific featured image.'),
                            ]),
                       Tab::make('Social Media')
                            ->schema([
                               TextInput::make('twitter_handle')
                                    ->label('Twitter Handle')
                                    ->prefix('@'),
                               TextInput::make('twitter_url')
                                    ->label('X (Twitter) URL')
                                    ->url(),
                               TextInput::make('facebook_url')
                                    ->label('Facebook URL')
                                    ->url(),
                               TextInput::make('instagram_url')
                                    ->label('Instagram URL')
                                    ->url(),
                               TextInput::make('linkedin_url')
                                    ->label('LinkedIn URL')
                                    ->url(),
                            ]),
                       Tab::make('Analytics')
                            ->schema([
                               TextInput::make('google_analytics_id')
                                    ->label('Google Analytics ID')
                                    ->placeholder('G-XXXXXXXXXX'),
                               TextInput::make('plausible_domain')
                                    ->label('Plausible Analytics Domain'),
                            ]),
                    ])->columnSpanFull(),
                
                Components\Tabs::make('Pages SEO')
                    ->tabs([
                        Components\Tabs\Tab::make('Home')
                            ->schema([
                                TextInput::make('home_title')->label('Page Title'),
                                Textarea::make('home_description')->label('Meta Description')->rows(2),
                            ]),
                       Tab::make('Scholarships')
                            ->schema([
                                TextInput::make('scholarships_title')->label('Page Title'),
                                Textarea::make('scholarships_description')->label('Meta Description')->rows(2),
                            ]),
                       Tab::make('Blog')
                            ->schema([
                                TextInput::make('blog_title')->label('Page Title'),
                                Textarea::make('blog_description')->label('Meta Description')->rows(2),
                            ]),
                       Tab::make('Resources')
                            ->schema([
                                TextInput::make('resources_title')->label('Page Title'),
                                Textarea::make('resources_description')->label('Meta Description')->rows(2),
                            ]),
                       Tab::make('FAQ')
                            ->schema([
                                TextInput::make('faq_title')->label('Page Title'),
                                Textarea::make('faq_description')->label('Meta Description')->rows(2),
                            ]),
                       Tab::make('Success Stories')
                            ->schema([
                                TextInput::make('stories_title')->label('Page Title'),
                                Textarea::make('stories_description')->label('Meta Description')->rows(2),
                            ]),
                       Tab::make('Tools')
                            ->schema([
                                TextInput::make('tools_title')->label('Page Title'),
                                Textarea::make('tools_description')->label('Meta Description')->rows(2),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
