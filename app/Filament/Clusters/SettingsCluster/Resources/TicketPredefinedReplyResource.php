<?php

namespace App\Filament\Clusters\SettingsCluster\Resources;

use App\Filament\Clusters\SettingsCluster;
use App\Filament\Clusters\SettingsCluster\Resources\TicketPredefinedReplyResource\Pages;
use App\Filament\Clusters\SettingsCluster\Resources\TicketPredefinedReplyResource\RelationManagers;
use App\Models\TicketPredefinedReply;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketPredefinedReplyResource extends Resource
{
    protected static ?string $model = TicketPredefinedReply::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = SettingsCluster::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ManageTicketPredefinedReplies::route('/'),
        ];
    }
}
