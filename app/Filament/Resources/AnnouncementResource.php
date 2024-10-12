<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Filament\Resources\AnnouncementResource\RelationManagers;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';

    public static function getNavigationGroup(): ?string
    {
        return __('Utilities');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('subject')
                    ->label(__('Title'))
                    ->required(),

                Forms\Components\RichEditor::make('message')
                    ->label(__('Content'))
                    ->required(),

                Forms\Components\Split::make([
                    Forms\Components\Checkbox::make('show_to_users')
                        ->label(__('Show to users')),

                    Forms\Components\Checkbox::make('show_to_clients')
                        ->label(__('Show to clients')),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject')
                    ->sortable()
                    ->searchable()
                    ->label(__('Title')),

                TextColumn::make('message')
                    ->limit(40)
                    ->html()
                    ->label(__('Content')),

                TextColumn::make('user.full_name')
                    ->sortable()
                    ->label(__('User Created')),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->description(function (Announcement $model) {
                        return $model->created_at->diffForHumans();
                    })
                    ->label(__('Created at'))
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnnouncements::route('/'),
            //'create' => Pages\CreateAnnouncement::route('/create'),
            //'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
