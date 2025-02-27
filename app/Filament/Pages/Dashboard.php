<?php

namespace App\Filament\Pages;

use App\Filament\Resources\SoftwareUpdateResource\Widgets\ArthemysInfo;
use App\Filament\Resources\UsersResource\Widgets\AccountInfo;
use App\Http\Controllers\DriverControl;
use App\Models\SoftwareUpdate;
use App\Models\SystemConfigs;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $navigationLabel = "Arthemys Dashboard";
    protected static ?string $navigationIcon = "heroicon-c-squares-2x2";
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];

    use HasFiltersAction;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('configs')
                ->label(__('manager.pages.dashboard.actions.label.configurations'))
                ->icon('heroicon-c-cog')
                ->fillForm(SystemConfigs::first()->toARray())
                ->form([
                    Group::make([
                        TextInput::make('title')
                            ->label(__('manager.pages.dashboard.actions.form.input.title'))
                            ->placeholder(__('manager.pages.dashboard.actions.form.placeholder.title'))
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label(__('manager.pages.dashboard.actions.form.input.description'))
                            ->placeholder(__('manager.pages.dashboard.actions.form.placeholder.description'))
                            ->columnSpanFull(),
                        FileUpload::make('logo_light')
                            ->disk('public')
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file) {
                                $fileName = Str::uuid() . '_light_.' . $file->getClientOriginalExtension();
                                return "system/logo/{$fileName}";
                            })
                            ->image()
                            ->imageEditor()
                            ->label(__('manager.pages.dashboard.actions.form.input.logo_light')),
                        FileUpload::make('logo_dark')
                            ->disk('public')
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file) {
                                $fileName = Str::uuid() . '_dark_.' . $file->getClientOriginalExtension();
                                return "system/logo/{$fileName}";
                            })
                            ->image()
                            ->imageEditor()
                            ->label(__('manager.pages.dashboard.actions.form.input.logo_dark')),
                        FileUpload::make('favicon')
                            ->disk('public')
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file) {
                                $fileName = Str::uuid() . '_dark_.' . $file->getClientOriginalExtension();
                                return "system/favicon/{$fileName}";
                            })
                            ->image()
                            ->imageEditor()
                            ->label(__('manager.pages.dashboard.actions.form.input.favicon')),
                        Group::make([
                            Select::make('ia_detect_object_driver')
                                ->label(__('manager.pages.dashboard.actions.form.input.ia_detect_object_driver'))
                                ->options(DriverControl::list())
                                ->columnSpanFull()
                        ])
                    ])->columns(2)
                ])
                ->action(function ($data) {
                    SystemConfigs::first()->update($data);
                    return Notification::make()
                        ->success()
                        ->title('Configurações atualizadas com sucesso!')
                        ->send();
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        $softwareInfo = SoftwareUpdate::orderByDesc('id', 'desc')->first();

        return [
            AccountInfo::class,
            ArthemysInfo::make([
                'version' => $softwareInfo->version
            ]),
        ];
    }
}
