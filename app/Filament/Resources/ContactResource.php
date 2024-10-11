<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
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
            ->columns(1)
            ->schema([
                Forms\Components\FileUpload::make('profile_photo')
                    ->avatar()
                    ->alignCenter()
                    ->label(__('Profile image'))
                    ->circleCropper(),

                Forms\Components\TextInput::make('first_name')
                    ->label(__('First name'))
                    ->required(),

                Forms\Components\TextInput::make('last_name')
                    ->label(__('Last name'))
                    ->required(),

                Forms\Components\TextInput::make('position')
                    ->label(__('Position')),

                TextInput::make('email')
                    ->prefixIcon('heroicon-o-at-symbol')
                    ->label(__('Email'))
                    ->email(),

                Forms\Components\TextInput::make('phone')
                    ->label(__('Phone'))
                    ->prefixIcon('heroicon-o-phone')
                    ->tel(),

                TextInput::make('password')
                    ->password()
                    ->disabledOn('edit')
                    ->label(__('Password'))
                    ->revealable(),

                Forms\Components\Checkbox::make('primary_contact')
                    ->label(__('Primary contact'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->sortable()
                    ->searchable()
                    ->description(function (Contact $record) {
                        return $record->position;
                    })
                    ->label(__('Full Name')),

                Tables\Columns\TextColumn::make('client.name')
                    ->sortable()
                    ->searchable()
                    ->label(__('Client')),

                Tables\Columns\ToggleColumn::make('active')
                    ->label(__('Active')),

                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->label(__('Email')),

                Tables\Columns\TextColumn::make('phone')
                    ->sortable()
                    ->searchable()
                    ->label(__('Phone')),


                Tables\Columns\TextColumn::make('last_login_at')
                    ->dateTime()
                    ->description(function (Contact $record) {
                        return $record->last_login_at->diffForHumans() ?? null;
                    })
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
