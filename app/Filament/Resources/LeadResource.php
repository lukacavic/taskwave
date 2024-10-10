<?php

namespace App\Filament\Resources;

use App\Filament\App\Resources\ClientResource;
use App\Filament\Clusters\SettingsCluster\Resources\LeadSourceResource;
use App\Filament\Clusters\SettingsCluster\Resources\LeadStatusResource;
use App\Filament\Resources\ClientResource\Pages\ClientContacts;
use App\Filament\Resources\ClientResource\Pages\ClientContracts;
use App\Filament\Resources\ClientResource\Pages\ClientDocuments;
use App\Filament\Resources\ClientResource\Pages\ClientNotes;
use App\Filament\Resources\ClientResource\Pages\ClientOverview;
use App\Filament\Resources\ClientResource\Pages\ClientTasks;
use App\Filament\Resources\LeadResource\Pages;
use App\Filament\Resources\LeadResource\Pages\LeadOverview;
use App\Filament\Resources\LeadResource\RelationManagers;
use App\Models\Client;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\Project;
use App\Models\User;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;
use Filament\Forms;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('company')
                    ->label(__('Company'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('position')
                    ->maxLength(255)
                    ->label(__('Position')),

                Forms\Components\TextInput::make('address')
                    ->maxLength(255)
                    ->label(__('Address')),

                Forms\Components\TextInput::make('city')
                    ->maxLength(255)
                    ->label(__('City')),

                Forms\Components\TextInput::make('zip_code')
                    ->maxLength(255)
                    ->label(__('Zip Code')),

                Forms\Components\TextInput::make('country')
                    ->label(__('Country'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('website')
                    ->maxLength(255)
                    ->label(__('Website'))
                    ->prefix('http://'),

                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->prefixIcon('heroicon-o-phone')
                    ->label(__('Phone'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->prefixIcon('heroicon-o-at-symbol')
                    ->label(__('Email'))
                    ->maxLength(255),

                Forms\Components\Select::make('status_id')
                    ->relationship('status', 'name')
                    ->required()
                    ->createOptionForm(function ($form) {
                        return LeadStatusResource::form($form);
                    })
                    ->createOptionUsing(function (array $data) {
                        return LeadStatus::query()->create($data)->id;
                    })
                    ->label(__('Status')),

                Forms\Components\Select::make('source_id')
                    ->relationship('source', 'name')
                    ->required()
                    ->createOptionForm(function ($form) {
                        return LeadSourceResource::form($form);
                    })
                    ->createOptionUsing(function (array $data) {
                        return LeadSource::query()->create($data)->id;
                    })
                    ->label(__('Source')),

                Forms\Components\Select::make('assigned_user_id')
                    ->prefixIcon('heroicon-o-user')
                    ->options(User::get()->pluck('fullName', 'id'))
                    ->label(__('Assigned User')),

                Forms\Components\DatePicker::make('last_contact_at')
                    ->label(__('Last Contact')),

                SpatieTagsInput::make('tags')
                    ->columnSpanFull()
                    ->label(__('Tags')),

                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->label(__('Description')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(
                fn(Model $record): string => LeadOverview::getUrl([$record->id]),
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Full Name'))
                    ->sortable()
                    ->description(function (Lead $record) {
                        return $record->company;
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->copyable()
                    ->copyMessage(__('Email copied'))
                    ->label(__('Email'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->label(__('Phone')),

                SpatieTagsColumn::make('tags')
                    ->color('gray')
                    ->label(__('Tags')),

                Tables\Columns\TextColumn::make('assignedUser.fullName')
                    ->label(__('Assigned User'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('source.name')
                    ->sortable()
                    ->label(__('Source'))
                    ->badge()
                    ->searchable(),

                Tables\Columns\TextColumn::make('status.name')
                    ->sortable()
                    ->badge()
                    ->label('Status'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label(__('Created At'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('last_contact_at')
                    ->label(__('Last Contact'))
                    ->dateTime()
                    ->searchable(),

                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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

    public static function sidebar(Model $record): FilamentPageSidebar
    {
        return FilamentPageSidebar::make()
            ->setTitle($record->name)
            ->sidebarNavigation()
            ->setDescription(__('Lead'))
            ->setNavigationItems([
                PageNavigationItem::make(__('Overview'))
                    ->icon('heroicon-o-information-circle')
                    ->url(function () use ($record) {
                        return static::getUrl('overview', ['record' => $record->id]);
                    })
                    ->isActiveWhen(function () {
                        return request()->routeIs(LeadOverview::getRouteName());
                    }),

                /*PageNavigationItem::make(__('Contacts'))
                    ->badge(function () use ($record) {
                        return $record->contacts->count();
                    })
                    ->icon('heroicon-o-users')
                    ->url(function () use ($record) {
                        return static::getUrl('contacts', ['record' => $record->id]);
                    })
                    ->isActiveWhen(function () {
                        return request()->routeIs(ClientContacts::getRouteName());
                    }),


                PageNavigationItem::make(__('Notes'))
                    ->icon('heroicon-o-pencil-square')
                    ->url(function () use ($record) {
                        return static::getUrl('notes', ['record' => $record->id]);
                    })
                    ->isActiveWhen(function () {
                        return request()->routeIs(ClientNotes::getRouteName());
                    }),

                PageNavigationItem::make(__('Documents'))
                    ->icon('heroicon-o-paper-clip')
                    ->url(function () use ($record) {
                        return static::getUrl('documents', ['record' => $record->id]);
                    })
                    ->isActiveWhen(function () {
                        return request()->routeIs(ClientDocuments::getRouteName());
                    }),

                PageNavigationItem::make(__('Tasks'))
                    ->icon('heroicon-o-rectangle-stack')
                    ->url(function () use ($record) {
                        return static::getUrl('tasks', ['record' => $record->id]);
                    })
                    ->isActiveWhen(function () {
                        return request()->routeIs(ClientTasks::getRouteName());
                    }),

                PageNavigationItem::make(__('Contracts'))
                    ->icon('heroicon-o-document-chart-bar')
                    ->url(function () use ($record) {
                        return static::getUrl('contracts', ['record' => $record->id]);
                    })
                    ->isActiveWhen(function () {
                        return request()->routeIs(ClientContracts::getRouteName());
                    }),*/
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            //'create' => Pages\CreateLead::route('/create'),
            //'edit' => Pages\EditLead::route('/{record}/edit'),
            'overview' => LeadOverview::route('/{record}/overview'),
        ];
    }
}
