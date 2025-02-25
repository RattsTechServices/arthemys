<?php

namespace App\Filament\Resources\SoftwareUpdateResource\Pages;

use App\Console\Commands\UpdateSoftware;
use App\Filament\Resources\SoftwareUpdateResource;
use App\Http\Controllers\UpdaterControl;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Artisan;

class ManageSoftwareUpdates extends ManageRecords
{
    protected static string $resource = SoftwareUpdateResource::class;

    protected function getHeaderActions(): array
    {
        $ARTHEMYS_UPDATER_SOURCE    = env('ARTHEMYS_UPDATER_SOURCE');
        $ARTHEMYS_UPDATER_PROVIDER  = env('ARTHEMYS_UPDATER_PROVIDER');
        $repoUrl  = "{$ARTHEMYS_UPDATER_SOURCE}/repos/{$ARTHEMYS_UPDATER_PROVIDER}/releases";
        $reliases = collect(UpdaterControl::getRepoDetails($repoUrl));

        return [
            Actions\Action::make('updater')
                ->icon('heroicon-c-arrow-path')
                ->label('Update Software')
                ->requiresConfirmation()
                ->modalDescription("This action will update Arthemys Software.")
                ->form([
                    Select::make('version')
                        ->options(function () use ($reliases) {
                            return $reliases->pluck('name', 'tag_name');
                        })
                        ->default($reliases->first()['tag_name'])
                ])
                ->action(function ($data) {
                    if (!isset($data['version'])) {
                        Artisan::call("software:update");
                    } else {
                        Artisan::call("software:update {$data['version']}");
                    }

                    Notification::make()
                        ->success()
                        ->title("Software update with success!")
                        ->send();
                }),

        ];
    }
}
