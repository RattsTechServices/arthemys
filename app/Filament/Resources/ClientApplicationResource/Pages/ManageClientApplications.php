<?php

namespace App\Filament\Resources\ClientApplicationResource\Pages;

use App\Filament\Resources\ClientApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageClientApplications extends ManageRecords
{
    protected static string $resource = ClientApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
