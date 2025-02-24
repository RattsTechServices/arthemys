<?php

namespace App\Filament\Resources\SoftwareUpdateResource\Pages;

use App\Filament\Resources\SoftwareUpdateResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Artisan;

class ManageSoftwareUpdates extends ManageRecords
{
    protected static string $resource = SoftwareUpdateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('updater')
                ->icon('heroicon-c-arrow-path')
                ->label('Update Software')
                ->requiresConfirmation()
                ->modalDescription("This action will update Arthemys Software.")
                ->action(function () {
                    Artisan::call('software:update');
                    Notification::make()
                        ->success()
                        ->title("Software update with success!")
                        ->send();
                }),

        ];
    }
}
