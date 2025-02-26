<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientApplicationResource\Pages;
use App\Filament\Resources\ClientApplicationResource\RelationManagers;
use App\Models\ClientApplication;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ClientApplicationResource extends Resource
{
    protected static ?string $model = ClientApplication::class;

    protected static ?string $navigationIcon = 'heroicon-c-cube';

    public static function getNavigationLabel(): string
    {
        return __('manager.menu_applications.plural');
    }

    public static function getLabel(): ?string
    {
        return __('manager.label_applications.single');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label(__('manager.client_application_resource.form.input.user_id'))
                    ->options(User::all()
                        ->map(function ($mp) {
                            $mp->name = "{$mp->id} - {$mp->name}, {$mp->email}";
                            return $mp;
                        })
                        ->pluck('name', 'id'))
                    ->required()
                    ->columnSpanFull()
                    ->searchable(),
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug_title', Str::slug($state)))
                    ->label(__('manager.client_application_resource.form.input.title'))
                    ->placeholder(__('manager.client_application_resource.form.placeholder.title')),
                TextInput::make('slug_title')
                    ->required()
                    ->label(__('manager.client_application_resource.form.input.slug_title'))
                    ->placeholder(__('manager.client_application_resource.form.placeholder.slug_title')),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull()
                    ->label(__('manager.client_application_resource.form.input.description'))
                    ->placeholder(__('manager.client_application_resource.form.placeholder.description')),
                TextInput::make('callback')
                    ->label(__('manager.client_application_resource.form.input.callback'))
                    ->placeholder(__('manager.client_application_resource.form.placeholder.callback'))
                    ->columnSpanFull(),
                TextInput::make('url')
                    ->required()
                    ->label(__('manager.client_application_resource.form.input.url'))
                    ->placeholder(__('manager.client_application_resource.form.placeholder.url')),
                TextInput::make('webhookie')
                    ->label(__('manager.client_application_resource.form.input.webhookie'))
                    ->placeholder(__('manager.client_application_resource.form.placeholder.webhookie')),
                Group::make([
                    Select::make('status')
                        ->label(__('manager.client_application_resource.form.input.status'))
                        ->default(1)
                        ->required()
                        ->options(['desativado', 'ativado']),
                    Select::make('webhookie_type')
                        ->label(__('manager.client_application_resource.form.input.webhookie_type'))
                        ->options(__('manager.client_application_resource.form.input._options.webhookie_type'))
                        ->required(),
                ])->columns(2),
                Select::make('condition')
                    ->default('aproved')
                    ->label(__('manager.client_application_resource.form.input.condition'))
                    ->required()
                    ->options([
                        'aproved' => "Aprovado",
                        'canceled' => "Cancelado",
                        'pedding' => "Pendente",
                        'blocked' => "Bloqueado"
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('manager.client_application_resource.table.id'))
                    ->sortable(),
                ImageColumn::make('logo_light')
                    ->label(__('manager.client_application_resource.table.logo_light'))
                    ->default("static/images/empty-image.png")
                    ->alignCenter(),
                TextColumn::make('title')
                    ->label(__('manager.client_application_resource.table.title'))
                    ->alignCenter(),
                TextColumn::make('slug_title')
                    ->color('primary')
                    ->label(__('manager.client_application_resource.table.slug_title'))
                    ->url(function ($record) {
                        return env('APP_URL') . "/{$record->slug_title}";
                    })
                    ->openUrlInNewTab()
                    ->alignCenter(),
                TextColumn::make('user.name')
                    ->label(__('manager.client_application_resource.table.user')),
                TextColumn::make('created_at')
                    ->label(__('manager.client_application_resource.table.created_at'))
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\Action::make('logo')
                        ->label("Alterar logo")
                        ->icon("heroicon-s-photo")
                        ->fillForm(function ($record) {
                            return [
                                'logo_light' => $record->logo_light,
                                'logo_dark' => $record->logo_dark
                            ];
                        })
                        ->form([
                            FileUpload::make('logo_light')
                                ->disk('public')
                                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file) {
                                    $fileName = Str::uuid() . '_light_.' . $file->getClientOriginalExtension();
                                    return "app/logo/{$fileName}";
                                })
                                ->image()
                                ->imageEditor()
                                ->columnSpanFull()
                                ->label('Logo da aplicação (light)'),
                            FileUpload::make('logo_dark')
                                ->disk('public')
                                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file) {
                                    $fileName = Str::uuid() . '_dark_.' . $file->getClientOriginalExtension();
                                    return "app/logo/{$fileName}";
                                })
                                ->image()
                                ->imageEditor()
                                ->columnSpanFull()
                                ->label('Logo da aplicação (dark)'),
                        ])
                        ->action(function ($data, $record) {
                            $record->update($data);
                        }),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),


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
            'index' => Pages\ManageClientApplications::route('/'),
        ];
    }
}
