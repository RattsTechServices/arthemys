<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ThemeManagerResource\Pages;
use App\Filament\Resources\ThemeManagerResource\RelationManagers;
use App\Http\Controllers\UnzipThemeController;
use App\Models\ThemeManager;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ThemeManagerResource extends Resource
{
    protected static ?string $model = ThemeManager::class;
    protected static ?string $navigationIcon = 'heroicon-m-paint-brush';

    public static function getNavigationLabel(): string {
        return __('manager.menu_themes.plural');
    }

    public static function getLabel(): ?string
    {
        return __('manager.label_themes.single');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ToggleColumn::make('is_active')
                    ->alignCenter()
                    ->label(__('manager.theme_manager_resources.table.is_active'))
                    ->afterStateUpdated(function ($record) {
                        ThemeManager::all()->map(function ($mp) use ($record) {
                            if ($mp->id !== $record->id && $mp->is_active == 1) {
                                $mp->update(['is_active' => 0]);
                            }
                        });
                    }),
                TextColumn::make('id')
                    ->label(__('manager.theme_manager_resources.table.id'))
                    ->sortable(),
                TextColumn::make('title')
                    ->label(__('manager.theme_manager_resources.table.title'))
                    ->alignCenter(),
                TextColumn::make('slug')
                    ->label(__('manager.theme_manager_resources.table.slug'))
                    ->sortable(),
                TextColumn::make('namespace')
                    ->label(__('manager.theme_manager_resources.table.namespace'))
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->label(__('manager.theme_manager_resources.table.created_at'))
                    ->dateTime(__('manager.theme_manager_resources.table._masks.created_at')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        try {
                            $theme = $record->info();
                            UnzipThemeController::delete($theme->slug);
                            return Notification::make()
                                ->title("Arquivo deletado com sucesso!")
                                ->success();
                        } catch (\Throwable $th) {
                            return Notification::make()
                                ->title("Oops! Um erro ocorreu")
                                ->body($th->getMessage())
                                ->danger();
                        }
                    }),
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
            'index' => Pages\ManageThemeManagers::route('/'),
        ];
    }
}
