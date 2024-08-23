<?php

namespace App\Filament\Resources\UserRoleResource\Pages;

use App\Filament\Resources\UserRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserRole extends CreateRecord
{
    protected static string $resource = UserRoleResource::class;
    // Redirect to the index page after creating a record
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
