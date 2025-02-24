<?php

namespace App\Filament\Resources\ThemeManagerResource\Pages;

use App\Filament\Resources\ThemeManagerResource;
use App\Http\Controllers\UnzipThemeController;
use App\Models\ThemeManager;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ManageThemeManagers extends ManageRecords
{
    protected static string $resource = ThemeManagerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('upload')
                ->label(__('manager.theme_manager_resources.form.action.upload'))
                ->icon('heroicon-c-arrow-up-tray')
                ->form([
                    FileUpload::make('file')
                        ->disk('public')
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file) {
                            $fileName = $file->getClientOriginalName();
                            return "storage/themes/{$fileName}";
                        })
                        ->columnSpanFull()
                        ->acceptedFileTypes(['application/zip', 'application/octet-stream', 'application/x-zip-compressed', 'multipart/x-zip'])
                        ->label(__('manager.theme_manager_resources.form.input.file'))
                        ->placeholder(__('manager.theme_manager_resources.form.placeholder.file')),
                ])
                ->action(function ($data) {
                    try {
                        $theme = UnzipThemeController::unzip(public_path($data['file']));

                        ThemeManager::create([
                            'title' => $theme->name,
                            'slug' => $theme->slug,
                            'namespace' => $theme->namespace,
                            'size' => filesize(public_path($data['file'])),
                            'sha256' => hash(
                                'sha256',
                                file_get_contents(
                                    public_path($data['file'])
                                )
                            ),
                            'is_active' => 0,
                            'url' => ($theme->url ?? null)
                        ]);

                        return Notification::make()
                            ->title(__('manager.theme_manager_resources.notifications.file.success.title'))
                            ->success()
                            ->send();
                    } catch (\Throwable $th) {
                        return Notification::make()
                            ->title(__('manager.theme_manager_resources.notifications.file.error.title'))
                            ->body($th->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
