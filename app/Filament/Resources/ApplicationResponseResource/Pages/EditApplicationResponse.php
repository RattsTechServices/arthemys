<?php

namespace App\Filament\Resources\ApplicationResponseResource\Pages;

use App\Filament\Resources\ApplicationResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApplicationResponse extends EditRecord
{
    protected static string $resource = ApplicationResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
