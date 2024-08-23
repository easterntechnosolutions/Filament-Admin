<?php

namespace App\Filament\Resources\StaffResource\Pages;

use App\Filament\Resources\StaffResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStaff extends CreateRecord
{
    protected static string $resource = StaffResource::class;
    // Redirect to the index page after creating a record
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
