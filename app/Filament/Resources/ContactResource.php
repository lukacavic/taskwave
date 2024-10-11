<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

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
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->sortable()
                    ->searchable()
                    ->label(__('Full Name')),

                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->label(__('Email')),

                Tables\Columns\TextColumn::make('client.name')
                    ->sortable()
                    ->searchable()
                    ->label(__('Client')),

                Tables\Columns\TextColumn::make('phone')
                    ->sortable()
                    ->searchable()
                    ->label(__('Phone')),

                Tables\Columns\TextColumn::make('position')
                    ->label(__('Position')),

                Tables\Columns\TextColumn::make('last_login_at')
                    ->dateTime()
                    ->label(__('Last Login')),
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
            'index' => Pages\ListContacts::route('/'),
            //'create' => Pages\CreateContact::route('/create'),
            //'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
