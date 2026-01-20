<?php

namespace App\Filament\Resources;

use Filament\Schemas;
use Filament\Schemas\Schema;
use App\Enums\UserRole;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';
    
    protected static string | \UnitEnum | null $navigationGroup = 'User Management';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
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
                Actions\EditAction::make(),
                Actions\Action::make('reset_password')
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
