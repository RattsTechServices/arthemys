<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsersResource\Pages;
use App\Filament\Resources\UsersResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsersResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-c-user';

    public static function getNavigationLabel(): string {
        return __('manager.menu_users.plural');
    }

    public static function getLabel(): ?string
    {
        return __('manager.label_users.single');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('manager.users_resources.form.input.name'))
                    ->placeholder(__('manager.users_resources.form.placeholder.name'))
                    ->required(),
                TextInput::make('email')
                    ->label(__('manager.users_resources.form.input.email'))
                    ->placeholder(__('manager.users_resources.form.placeholder.email'))
                    ->required(),
                TextInput::make('phone')
                    ->label(__('manager.users_resources.form.input.phone'))
                    ->placeholder(__('manager.users_resources.form.placeholder.phone'))
                    ->mask(__('manager.users_resources.form.mask.phone')),
                TextInput::make('password')
                    ->label(__('manager.users_resources.form.input.password'))
                    ->placeholder(__('manager.users_resources.form.placeholder.password'))
                    ->required()
                    ->password(true)
                    ->revealable()
                    ->columnSpanFull()
                    ->minValue(8)
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('manager.users_resources.table.id'))
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('manager.users_resources.table.name'))
                    ->searchable()
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('manager.users_resources.table.email'))
                    ->alignCenter()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label(__('manager.users_resources.table.phone'))
                    ->default(__('manager.users_resources.table._defaults.phone'))
                    ->alignCenter()
                    ->sortable()
                    ->badge(fn($record) => (!isset($record->phone) ? true : false)),
                TextColumn::make('created_at')
                    ->label(__('manager.users_resources.table.created_at'))
                    ->dateTime(__('manager.users_resources.table._masks.created_at'))
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
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
