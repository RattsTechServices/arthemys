<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientRegisterCollectionResource\Pages;
use App\Filament\Resources\ClientRegisterCollectionResource\RelationManagers;
use App\Models\ClientApplication;
use App\Models\ClientRegisterCollection;
use App\Models\RegisterInput;
use Filament\Forms;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientRegisterCollectionResource extends Resource
{
    protected static ?string $model = ClientRegisterCollection::class;
    protected static ?string $navigationIcon = 'heroicon-s-arrow-down-on-square-stack';

    public static function getNavigationLabel(): string {
        return __('manager.menu_registers.plural');
    }

    public static function getLabel(): ?string
    {
        return __('manager.label_registers.single');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('client_application_id')
                    ->label('Selecionar aplicação')
                    ->options(ClientApplication::all()
                        ->map(function ($mp) {
                            $mp->title = "{$mp->id} - {$mp->title}";
                            return $mp;
                        })
                        ->pluck('title', 'id'))
                    ->required()
                    ->columnSpanFull()
                    ->searchable(),
                KeyValue::make('collected')
                    ->label("Dados de registro")
                    ->deletable()
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('application.title')
                    ->label('Aplicação'),
                Group::make('created_at')
                    ->label('Data do registro')
                    ->getTitleFromRecordUsing(fn($record): string => date('d/m/Y', strtotime($record->created_at))),
            ])
            ->columns([
                TextColumn::make('id')
                    ->label('#ID')
                    ->sortable(),
                TextColumn::make('application.title')
                    ->label('Aplicação')
                    ->default("Aplicação deletada")
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
                            return "Descrição indisponível";
                        }

                        if (strlen($record->application->description) > 35) {
                            return substr($record->application->description, 0, 34) . "...";
                        }

                        return $record->application->description;
                    }),
                TextColumn::make('precollected')
                    ->label('Precoleta de dados')
                    ->alignCenter()
                    ->getStateUsing(function ($record) {
                        $result = null;
                        $inputs = RegisterInput::where('client_application_id', $record->client_application_id)
                            ->where('is_client_register_collection', 1)
                            ->get();

                        foreach ($inputs as $value) {
                            if ($record->precollected) {
                                if (in_array($value->name, array_keys($record->precollected))) {
                                    $result .= ":: {$record->precollected[$value->name]} ::";
                                }
                            }
                        }

                        if (!isset($result)) {
                            $result = "Sem dados Precoletados!";
                        }

                        return $result;
                    })
                    ->limit(35),
                TextColumn::make('itens')
                    ->label('Itens coletados')
                    ->color('primary')
                    ->alignCenter()
                    ->badge()
                    ->getStateUsing(function ($record) {
                        // dd($record->collected);
                        return count(array_values($record->collected ?? []));
                    }),
                TextColumn::make('created_at')
                    ->label('Data do reg.')
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
            'index' => Pages\ManageClientRegisterCollections::route('/'),
        ];
    }
}
