<?php

namespace App\Filament\Pages;

use App\Models\Scholarship;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\FieldOfStudy;
use App\Models\ScholarshipType;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportScholarships extends Page
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cloud-arrow-up';
    protected static \UnitEnum|string|null $navigationGroup = 'Scholarships';
    protected static ?string $title = 'Import Scholarships';
    protected static ?int $navigationSort = 100;

    protected string $view = 'filament.pages.import-scholarships';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Import Details')
                    ->description('Upload a CSV file containing scholarship data.')
                    ->schema([
                        FileUpload::make('csv_file')
                            ->label('CSV File')
                            ->required()
                            ->acceptedFileTypes(['text/csv', 'application/vnd.ms-excel'])
                            ->disk('local')
                            ->directory('imports'),
                        Select::make('default_status')
                            ->label('Default Status')
                            ->options(\App\Enums\ScholarshipStatus::class)
                            ->default(\App\Enums\ScholarshipStatus::ACTIVE)
                            ->required(),
                        Select::make('default_tier')
                            ->label('Default Sponsorship Tier')
                            ->options(\App\Enums\SponsorshipTier::class)
                            ->default(\App\Enums\SponsorshipTier::STANDARD)
                            ->required(),
                    ])
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $state = $this->form->getState();
        $filePath = Storage::disk('local')->path($state['csv_file']);

        if (!file_exists($filePath)) {
            Notification::make()
                ->title('File not found')
                ->danger()
                ->send();
            return;
        }

        $file = fopen($filePath, 'r');
        $header = fgetcsv($file);

        if (!$header) {
            Notification::make()
                ->title('Invalid CSV file')
                ->danger()
                ->send();
            return;
        }

        $count = 0;
        $errors = 0;

        while (($row = fgetcsv($file)) !== false) {
            try {
                $data = array_combine($header, $row);
                
                // Basic data mapping (adjust column names as needed)
                $title = $data['title'] ?? $data['Title'] ?? null;
                if (!$title) continue;

                $scholarship = Scholarship::create([
                    'title' => $title,
                    'slug' => Str::slug($title) . '-' . Str::random(5),
                    'description' => $data['description'] ?? $data['Description'] ?? '',
                    'provider_name' => $data['provider'] ?? $data['Provider'] ?? 'Unknown',
                    'application_url' => $data['url'] ?? $data['URL'] ?? $data['link'] ?? '#',
                    'award_amount' => (float)($data['amount'] ?? $data['Amount'] ?? 0),
                    'primary_deadline' => !empty($data['deadline']) ? date('Y-m-d', strtotime($data['deadline'])) : null,
                    'status' => $state['default_status'],
                    'sponsorship_tier' => $state['default_tier'],
                ]);

                // Optional: Map relationships if columns exist
                if (!empty($data['countries'])) {
                    $countryNames = explode(',', $data['countries']);
                    $countryIds = Country::whereIn('name', array_map('trim', $countryNames))->pluck('id');
                    $scholarship->countries()->sync($countryIds);
                }

                $count++;
            } catch (\Exception $e) {
                $errors++;
            }
        }

        fclose($file);
        Storage::disk('local')->delete($state['csv_file']);

        Notification::make()
            ->title('Import Completed')
            ->body("Successfully imported {$count} scholarships. Errors: {$errors}")
            ->success()
            ->send();

        $this->form->fill();
    }
}
