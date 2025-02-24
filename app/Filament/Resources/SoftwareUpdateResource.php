<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoftwareUpdateResource\Pages;
use App\Filament\Resources\SoftwareUpdateResource\RelationManagers;
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
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('manager.software_update_resources.table.id'))
                    ->sortable(),
                TextColumn::make('version')
                    ->label(__('manager.software_update_resources.table.version'))
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('repository')
                    ->label(__('manager.software_update_resources.table.repository'))
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('artefact')
                    ->label(__('manager.software_update_resources.table.artefact'))
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('size')
                    ->label(__('manager.software_update_resources.table.size'))
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('manager.software_update_resources.table.created_at'))
                    ->dateTime(__('manager.software_update_resources.table._masks.created_at'))
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
