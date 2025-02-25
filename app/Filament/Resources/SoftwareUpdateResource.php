<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoftwareUpdateResource\Pages;
use App\Filament\Resources\SoftwareUpdateResource\RelationManagers;
use App\Http\Controllers\UtilsController;
use App\Models\SoftwareUpdate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SoftwareUpdateResource extends Resource
{
    protected static ?string $model = SoftwareUpdate::class;
    protected static ?string $navigationIcon = 'heroicon-c-arrow-path';

    public static function getNavigationLabel(): string
    {
        return __('manager.menu_updater.plural');
    }

    public static function getLabel(): ?string
    {
        return __('manager.label_updater.single');
    }

    public static function table(Table $table): Table
    {
        $lastReliase = SoftwareUpdate::orderBy('id', 'desc')->first();

        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label(__('manager.software_update_resources.table.id'))
                    ->sortable(),
                TextColumn::make('version')
                    ->label(__('manager.software_update_resources.table.version'))
                    ->color(function ($record) use ($lastReliase) {
                        if ($record->version == $lastReliase->version) {
                            return 'primary';
                        } else {
                            return 'gray';
                        }
                    })
                    ->badge()
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('repository')
                    ->label(__('manager.software_update_resources.table.repository'))
                    ->icon('heroicon-c-share')
                    ->color(function ($record) use ($lastReliase) {
                        if ($record->version == $lastReliase->version) {
                            return 'primary';
                        } else {
                            return 'gray';
                        }
                    })
                    ->badge()
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('artefact')
                    ->label(__('manager.software_update_resources.table.artefact'))
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->color(function ($record) use ($lastReliase) {
                        if ($record->version == $lastReliase->version) {
                            return 'primary';
                        } else {
                            return 'gray';
                        }
                    })
                    ->url(function ($record) {
                        return $record->artefact;
                    })
                    ->openUrlInNewTab()
                    ->limit(18)
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('size')
                    ->label(__('manager.software_update_resources.table.size'))
                    ->icon('heroicon-c-cube')
                    ->getStateUsing(fn($record) => UtilsController::convertBytes($record->size, 'MB'))
                    ->color(function ($record) use ($lastReliase) {
                        if ($record->version == $lastReliase->version) {
                            return 'primary';
                        } else {
                            return 'gray';
                        }
                    })
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('manager.software_update_resources.table.created_at'))
                    ->dateTime(__('manager.software_update_resources.table._masks.created_at'))
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label(__('manager.software_update_resources.table.updated_at'))
                    ->dateTime(__('manager.software_update_resources.table._masks.updated_at'))
                    ->alignCenter()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSoftwareUpdates::route('/'),
        ];
    }
}
