<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;
    // Redirect to the index page after creating a record
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
