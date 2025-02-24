<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegisterStepResource\Pages;
use App\Filament\Resources\RegisterStepResource\RelationManagers;
use App\Models\ClientApplication;
use App\Models\RegisterInput;
use App\Models\RegisterStep;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class RegisterStepResource extends Resource
{
    protected static ?string $model = RegisterStep::class;
    protected static ?string $navigationIcon = 'heroicon-c-numbered-list';

    public static function getNavigationLabel(): string
    {
        return __('manager.menu_steps.plural');
    }

    public static function getLabel(): ?string
    {
        return __('manager.label_steps.single');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label(__('manager.register_step_resource.form.input.title'))
                    ->placeholder(__('manager.register_step_resource.form.placeholder.title'))
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('identify', Str::slug($state, '_')))
                    ->live(onBlur: true)
                    ->columnSpanFull()
                    ->required(),
                Textarea::make('description')
                    ->label(__('manager.register_step_resource.form.input.description'))
                    ->placeholder(__('manager.register_step_resource.form.placeholder.description'))
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('step')
                    ->label(__('manager.register_step_resource.form.input.step'))
                    ->placeholder(__('manager.register_step_resource.form.placeholder.step'))
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->maxValue(10),
                TextInput::make('identify')
                    ->label(__('manager.register_step_resource.form.input.identify'))
                    ->placeholder(__('manager.register_step_resource.form.placeholder.description')),
                Select::make('client_application_id')
                    ->label(__('manager.register_step_resource.form.input.client_application_id'))
                    ->options(ClientApplication::all()
                        ->map(function ($mp) {
                            $mp->title = "{$mp->id} - {$mp->title}";
                            return $mp;
                        })
                        ->pluck('title', 'id'))
                    ->required()
                    ->searchable(),
                Select::make(__('manager.register_step_resource.form.input.status'))
                    ->label(__('manager.register_step_resource.form.placeholder.status'))
                    ->options(__('manager.register_step_resource.form.input._select.status'))
                    ->default(0)
                    ->required()
                    ->searchable(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('manager.register_step_resource.table.id'))
                    ->sortable(),
                TextColumn::make('title')
                    ->label(__('manager.register_step_resource.table.title'))
                    ->tooltip(__('manager.register_step_resource.table._tooltips.title'))
                    ->description(function ($record) {
                        if (strlen($record->description) > 28) {
                            return substr($record->description, 0, 28) . "...";
                        };

                        return $record->description;
                    })
                    ->limit(28),
                ToggleColumn::make('status')
                    ->label(__('manager.register_step_resource.table.status'))
                    ->tooltip(__('manager.register_step_resource.table._tooltips.status')),
                TextColumn::make('client_application.title')
                    ->label(__('manager.register_step_resource.table.client_application'))
                    ->tooltip(__('manager.register_step_resource.table._tooltips.client_application'))
                    ->alignCenter()
                    ->color('info')
                    ->icon('heroicon-c-cube')
                    ->badge()
                    ->limit(28),
                TextColumn::make('register_inputs')
                    ->label(__('manager.register_step_resource.table.register_inputs'))
                    ->tooltip(__('manager.register_step_resource.table._tooltips.register_inputs'))
                    ->color('success')
                    ->icon('heroicon-s-information-circle')
                    ->alignCenter()
                    ->getStateUsing(function ($record) {
                        return $record->register_inputs()->count();
                    })
                    ->badge(),
                TextColumn::make('created_at')
                    ->label(__('manager.register_step_resource.table.created_at'))
                    ->tooltip(__('manager.register_step_resource.table._tooltips.created_at'))


            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\Action::make('inputs')
                        ->label('Itens')
                        ->icon('heroicon-c-bars-3-bottom-left'),
                ])
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
            'index' => Pages\ManageRegisterSteps::route('/'),
        ];
    }
}
