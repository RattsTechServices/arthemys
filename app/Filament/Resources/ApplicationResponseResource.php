<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationResponseResource\Pages;
use App\Filament\Resources\ApplicationResponseResource\RelationManagers;
use App\Models\ApplicationResponse;
use App\Models\ClientApplication;
use App\Models\ClientRegisterCollection;
use Filament\Forms;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicationResponseResource extends Resource
{
    protected static ?string $model = ApplicationResponse::class;

    protected static ?string $navigationIcon = 'heroicon-s-square-3-stack-3d';

    public static function getNavigationLabel(): string
    {
        return __("Responses");
    }

    public static function getLabel(): ?string
    {
        return __("Response");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('client_application_id')
                    ->label(__('manager.client_register_collection_resource.form.input.client_application_id'))
                    ->options(ClientApplication::all()
                        ->map(function ($mp) {
                            $mp->title = "{$mp->id} - {$mp->title}";
                            return $mp;
                        })
                        ->pluck('title', 'id'))
                    ->required()
                    ->searchable(),
                Select::make('client_register_collection_id')
                    ->label("Client register collections")
                    ->options(ClientRegisterCollection::all()
                        ->map(function ($mp) {
                            $mp->title = "ID: {$mp->id} - IP: {$mp->register_ip} - {$mp->session_id}";
                            return $mp;
                        })
                        ->pluck('title', 'id'))
                    ->required()
                    ->searchable(),
                KeyValue::make('content')
                    ->label('Content')
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('application.title')
                    ->label(__('manager.client_register_collection_resource.table.application'))
                    ->default(__('manager.client_register_collection_resource.table._defaults.application'))
                    ->icon(function ($record) {
                        if (!isset($record->application)) {
                            return "heroicon-s-x-circle";
                        }
                        return "heroicon-s-check-circle";
                    })
                    ->color(function ($record) {
                        if (!isset($record->application)) {
                            return "danger";
                        }
                        return "primary";
                    })
                    ->description(function ($record) {
                        if (!isset($record->application)) {
                            return __('manager.client_register_collection_resource.table._descriptions.application');
                        }

                        if (strlen($record->application->description) > 35) {
                            return substr($record->application->description, 0, 34) . "...";
                        }

                        return $record->application->description;
                    }),
                TextColumn::make('clientRegisterCollection.session_id')
                    ->label('Session ID')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Created at')
                    ->dateTime('d/m/Y H:i')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplicationResponses::route('/'),
            'create' => Pages\CreateApplicationResponse::route('/create'),
            'edit' => Pages\EditApplicationResponse::route('/{record}/edit'),
        ];
    }
}
