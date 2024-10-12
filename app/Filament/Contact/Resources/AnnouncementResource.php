<?php

namespace App\Filament\Contact\Resources;

use App\Filament\Contact\Resources\AnnouncementResource\Pages;
use App\Filament\Contact\Resources\AnnouncementResource\RelationManagers;
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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

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
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('show_to_clients', true)->latest();
            })
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
