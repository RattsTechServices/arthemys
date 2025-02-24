<?php

namespace App\Filament\Resources\RegisterInputResource\Pages;

use App\Filament\Resources\RegisterInputResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRegisterInputs extends ManageRecords
{
    protected static string $resource = RegisterInputResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
