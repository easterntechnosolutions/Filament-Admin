<?php

namespace App\Filament\Resources\UserProfileResource\Pages;

use App\Filament\Resources\UserProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserProfile extends CreateRecord
{
    protected static string $resource = UserProfileResource::class;
    // Redirect to the index page after creating a record
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
