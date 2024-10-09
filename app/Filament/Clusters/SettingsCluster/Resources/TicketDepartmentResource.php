<?php

namespace App\Filament\Clusters\SettingsCluster\Resources;

use App\Filament\Clusters\SettingsCluster;
use App\Filament\Clusters\SettingsCluster\Resources\TicketDepartmentResource\Pages;
use App\Filament\Clusters\SettingsCluster\Resources\TicketDepartmentResource\RelationManagers;
use App\Models\TicketDepartment;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketDepartmentResource extends Resource
{
    protected static ?string $model = TicketDepartment::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $cluster = SettingsCluster::class;

    public static function getNavigationLabel(): string
    {
        return __('Departments');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Support');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label(__('Name')),

                Forms\Components\TextInput::make('email')
                    ->prefixIcon('heroicon-o-at-symbol')
                    ->label(__('Email'))
                    ->email()
                    ->required(),

                Forms\Components\Placeholder::make('IMAP configuration')
                    ->label('IMAP configuration'),

                Forms\Components\TextInput::make('imap_host')
                    ->label(__('IMAP Host')),

                Forms\Components\Split::make([
                    Forms\Components\TextInput::make('imap_username')
                        ->label(__('IMAP Username')),

                    TextInput::make('imap_password')
                        ->revealable()
                        ->label(__('Password'))
                        ->password(),
                ]),

                Forms\Components\ToggleButtons::make('imap_encryption')
                    ->inline()
                    ->default('none')
                    ->options([
                        'tls' => 'TLS',
                        'ssl' => 'SSL',
                        'none' => 'None',
                    ]),

                Forms\Components\Select::make('imap_folder')
                    ->prefixIcon('heroicon-o-folder')
                    ->hintAction(function () {
                        return Forms\Components\Actions\Action::make('retrieve')
                            ->label(__('Retrieve folders'));
                    })
                    ->label(__('Folder')),

                Forms\Components\Checkbox::make('delete_after_import')
                ->label(__('Delete After Import'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name')),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email')),
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
            'index' => Pages\ManageTicketDepartments::route('/'),
        ];
    }
}
