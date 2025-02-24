<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegisterInputResource\Pages;
use App\Filament\Resources\RegisterInputResource\RelationManagers;
use App\Models\ClientApplication;
use App\Models\RegisterInput;
use App\Models\RegisterStep;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class RegisterInputResource extends Resource
{
    protected static ?string $model = RegisterInput::class;
    protected static ?string $navigationIcon = 'heroicon-c-bars-3-bottom-left';

    public static function getNavigationLabel(): string
    {
        return __('manager.menu_inputs.plural');
    }

    public static function getLabel(): ?string
    {
        return __('manager.label_inputs.single');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('label')
                    ->label(__('manager.register_input_resource.form.input.label'))
                    ->placeholder(__('manager.register_input_resource.form.placeholder.label'))
                    ->columnSpanFull()
                    ->required(),
                Select::make('register_step_id')
                    ->label(__('manager.register_input_resource.form.input.register_step_id'))
                    ->options(RegisterStep::all()->pluck('title', 'id'))
                    ->default(RegisterStep::first()->id)
                    ->afterStateUpdated(fn(Get $get, Set $set, ?string $state) => $set('client_application_id', RegisterStep::where('id', $get('register_step_id'))->first()->client_application_id))
                    ->live()
                    ->required(),
                Group::make([
                    Select::make('client_application_id')
                        ->label(__('manager.register_input_resource.form.input.client_application_id'))
                        ->options(
                            function () {
                                $applications = ClientApplication::all();
                                return $applications->pluck('title', 'id');
                            }
                        )
                        ->default(ClientApplication::first()->id)
                        ->required()
                        ->searchable(),
                    Select::make('type')
                        ->label(__('manager.register_input_resource.form.input.type'))
                        ->options(__('manager.register_input_resource.form.input._select.type'))
                        ->default('text')
                        ->required()
                        ->live(onBlur: false),
                ])
                    ->columns(2),

                TextInput::make('name')
                    ->label(__('manager.register_input_resource.form.input.name'))
                    ->placeholder(__('manager.register_input_resource.form.placeholder.name'))
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('name', Str::slug($state, '_')))
                    ->live(onBlur: true)
                    ->required(),
                TextInput::make('placeholder')
                    ->label(__('manager.register_input_resource.form.input.placeholder'))
                    ->placeholder(__('manager.register_input_resource.form.placeholder.placeholder')),
                TextInput::make('value')
                    ->label(__('manager.register_input_resource.form.input.value'))
                    ->placeholder(__('manager.register_input_resource.form.placeholder.value')),
                TextInput::make('mask')
                    ->label(__('manager.register_input_resource.form.input.mask'))
                    ->placeholder(__('manager.register_input_resource.form.placeholder.mask')),

                Toggle::make('required')
                    ->label(__('manager.register_input_resource.form.input.required'))
                    ->columnSpanFull(),
                KeyValue::make('options')
                    ->label(__('manager.register_input_resource.form.input.options'))
                    ->addActionLabel(__('manager.register_input_resource.form.input._key_value.options.add_action_label'))
                    ->keyPlaceholder(__('manager.register_input_resource.form.input._key_value.options.key_placeholder'))
                    ->valuePlaceholder(__('manager.register_input_resource.form.input._key_value.options.value_placeholder'))
                    ->hidden(fn(Get $get): bool => $get('type') !== 'select')
                    ->reorderable()
                    ->columnSpanFull(),
                Select::make('ai_auto_verify')
                    ->label(__('manager.register_input_resource.form.input.ai_auto_verify'))
                    ->options(__('manager.register_input_resource.form.input._options.ai_auto_verify'))
                    ->default(0)
                    ->hidden(fn(Get $get): bool => !in_array($get('type'), ['face-cam'])),
                RichEditor::make('html')
                    ->label(__('manager.register_input_resource.form.input.html'))
                    ->hidden(fn(Get $get): bool => $get('type') !== 'card')
                    ->columnSpanFull()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->defaultGroup('register_step.title')
            ->groups([
                'register_step.title',
                'type'
            ])
            ->columns([
                TextColumn::make('id')
                    ->label(__('manager.register_input_resource.table.id'))
                    ->sortable(),
                TextColumn::make('register_step.title')
                    ->label(__('manager.register_input_resource.table.title'))
                    ->description(function ($record) {
                        if (strlen($record->register_step()->first()->description) > 28) {
                            return substr($record->register_step()->first()->description, 0, 28) . "...";
                        };

                        return $record->register_step()->first()->description;
                    })
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->limit(26),
                TextColumn::make('label')
                    ->label(__('manager.register_input_resource.table.label'))
                    ->alignCenter()
                    ->searchable(),
                TextColumn::make('type')
                    ->label(__('manager.register_input_resource.table.type'))
                    ->alignCenter()
                    ->sortable()
                    ->badge()
                    ->color(function ($record) {
                        if ($record->type == 'text') {
                            return 'primary';
                        } else if ($record->type == 'select') {
                            return 'gray';
                        } else if ($record->type == 'checkbox') {
                            return 'warning';
                        } else if ($record->type == 'password') {
                            return 'success';
                        } else if ($record->type == 'email') {
                            return 'info';
                        }
                    }),
                ToggleColumn::make('required')
                    ->label(__('manager.register_input_resource.table.required'))
                    ->alignCenter()
                    ->sortable(),
                ToggleColumn::make('is_client_register_collection')
                    ->alignCenter()
                    ->label(__('manager.register_input_resource.table.is_client_register_collection')),
                TextColumn::make('created_at')
                    ->label(__('manager.register_input_resource.table.created_at'))
            ])
            ->filters([
                SelectFilter::make('register_step')
                    ->label("Filter by step")
                    ->options(RegisterStep::all()->pluck('title', 'id')),
                SelectFilter::make('required')
                    ->label("Filter by required")
                    ->options(["Not required", "Is required"]),

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
            'index' => Pages\ManageRegisterInputs::route('/'),
        ];
    }
}
