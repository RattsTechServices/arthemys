<?php

namespace App\Filament\Resources\ClientRegisterCollectionResource\Pages;

use App\Filament\Resources\ClientRegisterCollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageClientRegisterCollections extends ManageRecords
{
    protected static string $resource = ClientRegisterCollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
