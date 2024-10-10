<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\Pages\ClientContacts;
use App\Filament\Resources\ClientResource\Pages\ClientDocuments;
use App\Filament\Resources\ClientResource\Pages\ClientNotes;
use App\Filament\Resources\ClientResource\Pages\ClientOverview;
use App\Filament\Resources\ClientResource\Widgets\ClientStats;
use App\Models\Client;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Client'))
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->prefixIcon('heroicon-o-phone')
                    ->label(__('Phone')),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->prefixIcon('heroicon-o-at-symbol')
                    ->label(__('Email')),

                Forms\Components\TextInput::make('website')
                    ->label(__('Website'))
                    ->prefix('https://')
                    ->maxLength(255),

                Forms\Components\TextInput::make('address')
                    ->label(__('Address'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('city')
                    ->label(__('City'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('zip_code')
                    ->label(__('ZIP'))
                    ->maxLength(255),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(
                fn(Model $record): string => ClientOverview::getUrl([$record->id]),
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->description(function (Client $record) {
                        return Str::limit($record->full_address, 30);
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email')),

                Tables\Columns\TextColumn::make('phone')
                    ->color('primary')
                    ->copyable()
                    ->label(__('Phone')),

                Tables\Columns\ToggleColumn::make('active')
                    ->label(__('Active')),

                Tables\Columns\TextColumn::make('groups.name')
                    ->label(__('Groups'))
                    ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
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

    public static function getWidgets(): array
    {
        return [
            ClientStats::class
        ];
    }

    public static function sidebar(Model $record): FilamentPageSidebar
    {
        return FilamentPageSidebar::make()
            ->setTitle($record->name)
            ->sidebarNavigation()
            ->setDescription(__('Client'))
            ->setNavigationItems([
                PageNavigationItem::make(__('Overview'))
                    ->icon('heroicon-o-information-circle')
                    ->url(function () use ($record) {
                        return static::getUrl('overview', ['record' => $record->id]);
                    })
                    ->isActiveWhen(function () {
                        return request()->routeIs(ClientOverview::getRouteName());
                    }),

                PageNavigationItem::make(__('Contacts'))
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            //'create' => Pages\CreateClient::route('/create'),
            //'edit' => Pages\EditClient::route('/{record}/edit'),
            'overview' => ClientOverview::route('/{record}/overview'),
            'notes' => ClientNotes::route('/{record}/notes'),
            'documents' => ClientDocuments::route('/{record}/documents'),
            'contacts' => ClientContacts::route('/{record}/contacts'),
        ];
    }
}
