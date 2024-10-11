<?php

namespace App\Filament\Clusters\SettingsCluster\Resources;

use App\Filament\Clusters\SettingsCluster;
use App\Filament\Clusters\SettingsCluster\Resources\UserResource\Pages;
use App\Filament\Clusters\SettingsCluster\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->label(__('First Name'))
                    ->required(),

                Forms\Components\TextInput::make('last_name')
                    ->label(__('Last Name'))
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label(__('Email'))
                    ->email()
                    ->prefixIcon('heroicon-o-at-symbol')
                    ->required(),

                Forms\Components\TextInput::make('phone')
                    ->label(__('Phone'))
                    ->tel()
                    ->prefixIcon('heroicon-o-phone'),

                Forms\Components\Split::make([
                    Forms\Components\Toggle::make('active')
                        ->label(__('Active'))
                        ->default(true),

                    Forms\Components\Toggle::make('administrator')
                        ->label(__('Administrator'))
                        ->disabled(!auth()->user()->administrator)
                        ->default(false),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->sortable()
                    ->searchable()
                    ->label(__('Full Name')),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label(__('Email')),

                Tables\Columns\ToggleColumn::make('administrator')
                    ->label(__('Administrator'))
                    ->disabled(!auth()->user()->administrator),

                Tables\Columns\ToggleColumn::make('active')
                    ->label(__('Active')),

                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->searchable()
                    ->dateTime()
                    ->description(function (User $record) {
                        return $record->created_at->diffForHumans();
                    })
                    ->label(__('Created At')),
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
