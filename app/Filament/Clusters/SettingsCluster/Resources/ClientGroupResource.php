<?php

namespace App\Filament\Clusters\SettingsCluster\Resources;

use App\Filament\Clusters\SettingsCluster;
use App\Filament\Clusters\SettingsCluster\Resources\ClientGroupResource\Pages;
use App\Filament\Clusters\SettingsCluster\Resources\ClientGroupResource\RelationManagers;
use App\Models\ClientGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientGroupResource extends Resource
{
    protected static ?string $model = ClientGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('Clients');
    }

    public static function getNavigationLabel(): string
    {
        return __('Groups');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\ColorPicker::make('color')
                    ->label(__('Color')),

                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColorColumn::make('color')
                    ->label(__('Color')),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
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
            'index' => Pages\ManageClientGroups::route('/'),
        ];
    }
}
