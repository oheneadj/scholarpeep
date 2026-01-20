<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $password = Str::random(12);
        $data['password'] = Hash::make($password);
        
        // Store raw password temporarily to show/email it
        session()->flash('generated_password', $password);
        
        return $data;
    }
    
    protected function afterCreate(): void
    {
        $record = $this->getRecord();
        $password = session('generated_password');
        
        // TODO: Send email
        
        \Filament\Notifications\Notification::make()
            ->title('User Created')
            ->body("User {$record->name} created. Password: {$password}")
            ->success()
            ->persistent()
            ->send();
    }
}
