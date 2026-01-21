<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Tables;
use Filament\Actions;
use Filament\Schemas;
use App\Enums\UserRole;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Schemas\Components\Section;
use App\Filament\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';
    
    protected static string | \UnitEnum | null $navigationGroup = 'User Management';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                ->schema([
                     Components\FileUpload::make('avatar')
                    ->image()
                    ->disk('public')
                    ->directory('avatars')
                    ->visibility('public')
                    ->avatar()
                    ->imageEditor()
                    ->circleCropper(),
                    Components\TextInput::make('name')
                    ->required()
                    ->placeholder('e.g. John Doe')
                    ->maxLength(255),
                Components\TextInput::make('email')
                    ->email()
                    ->placeholder('e.g. johndoe@example.com')
                    ->required()
                    ->maxLength(255),
               
                Components\Textarea::make('bio')
                    ->maxLength(100)
                    ->placeholder('e.g. I am a student')
                    ->rows(3)
                    ->helperText('Brief bio (max 100 characters)'),
                Components\Select::make('role')
                    ->options(UserRole::class)
                    ->required()
                    ->default(UserRole::USER)
                    ->disabled(fn ($record) => $record?->role === UserRole::SUPER_ADMIN)
                    ->helperText(fn ($record) => $record?->role === UserRole::SUPER_ADMIN ? 'Super Admin role cannot be changed' : null),
                Components\Toggle::make('is_active')
                    ->required()
                    ->default(true)
                    ->disabled(fn ($record) => $record?->role === UserRole::SUPER_ADMIN)
                    ->helperText(fn ($record) => $record?->role === UserRole::SUPER_ADMIN ? 'Super Admin cannot be disabled' : null),
            
                ])
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options(UserRole::class),
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Actions\EditAction::make()
                ->label('Edit')
                ->icon('heroicon-o-pencil')
                ->button(),
                Actions\Action::make('reset_password')
                    ->label('Reset Password')
                    ->button()
                    ->color('success')
                    ->icon('heroicon-o-key')
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        $password = Str::random(12);
                        $record->update(['password' => Hash::make($password)]);
                        
                        // Send email
                        // Notification::make()->title('Password Reset')->body("New password: $password")->sendToDatabase($record); // Better to send real email
                        
                        // For now, show notification to admin
                        \Filament\Notifications\Notification::make()
                            ->title('Password Reset')
                            ->body("Password updated for {$record->name}. New password: {$password}")
                            ->success()
                            ->persistent()
                            ->send();
                    }),
                Actions\DeleteAction::make()
                ->label('Delete')->button()
                    ->hidden(fn (User $record) => $record->role === UserRole::SUPER_ADMIN),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make()
                        ->action(function ($records) {
                            // Filter out Super Admins before deleting
                            $records->filter(fn ($record) => $record->role !== UserRole::SUPER_ADMIN)->each->delete();
                            
                            \Filament\Notifications\Notification::make()
                                ->title('Users deleted')
                                ->body('Selected users have been deleted (Super Admins were skipped)')
                                ->success()
                                ->send();
                        }),
                ]),
            ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
