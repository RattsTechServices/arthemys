<?php

namespace App\Filament\Resources\RegisterStepResource\Pages;

use App\Filament\Resources\RegisterStepResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRegisterSteps extends ManageRecords
{
    protected static string $resource = RegisterStepResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
