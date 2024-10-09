<?php

namespace App\Filament\Clusters\SettingsCluster\Resources;

use App\Filament\Clusters\SettingsCluster;
use App\Filament\Clusters\SettingsCluster\Resources\TicketSpamFilterResource\Pages;
use App\Filament\Clusters\SettingsCluster\Resources\TicketSpamFilterResource\RelationManagers;
use App\Models\TicketSpamFilter;
use App\TicketSpamFilterType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketSpamFilterResource extends Resource
{
    protected static ?string $model = TicketSpamFilter::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-minus';

    protected static ?string $cluster = SettingsCluster::class;

    public static function getNavigationGroup(): ?string
    {
        return __('Support');
    }

    public static function getNavigationLabel(): string
    {
        return __('Spam Filters');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Select::make('type_id')
                    ->label(__('Type'))
                    ->options(TicketSpamFilterType::class)
                    ->required(),

                Forms\Components\Textarea::make('content')
                    ->required()
                    ->label(__('Content'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type_id')
                    ->label(__('Type'))
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        return TicketSpamFilterType::from($state)->getLabel();
                    }),

                Tables\Columns\TextColumn::make('content')
                    ->label(__('Content'))
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
            'index' => Pages\ManageTicketSpamFilters::route('/'),
        ];
    }
}
