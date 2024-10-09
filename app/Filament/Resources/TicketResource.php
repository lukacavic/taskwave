<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Main informations')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('subject')
                            ->label(__('Subject'))
                            ->required(),

                        Forms\Components\Select::make('contact_id')
                            ->label(__('Contact'))
                            ->required(),

                        Forms\Components\Select::make('department_id')
                            ->label(__('Department'))
                            ->required(),

                        Forms\Components\Select::make('assigned_user_id')
                            ->label(__('Assigned User')),

                        Forms\Components\Select::make('priority_id')
                            ->label(__('Priority')),

                        Forms\Components\SpatieTagsInput::make('tags')
                            ->label(__('Tags')),
                    ]),

                Forms\Components\Section::make('Ticket body')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('predefined_reply')
                            ->label(__('Predefined Reply')),

                        Forms\Components\Select::make('knowledge_link')
                            ->label(__('Knowledge Link')),

                        Forms\Components\RichEditor::make('body')
                            ->columnSpanFull()
                            ->label(__('Body'))
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject')
                    ->label(__('Subject'))
                    ->searchable(),

                SpatieTagsColumn::make('tags')
                    ->color('gray')
                    ->label(__('Tags')),

                Tables\Columns\TextColumn::make('department.name')
                    ->label(__('Department'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('contact.full_name')
                    ->label(__('Contact')),

                Tables\Columns\TextColumn::make('status_id')
                    ->label(__('Status'))
                    ->badge(),

                Tables\Columns\TextColumn::make('priority_id')
                    ->sortable()
                    ->label(__('Priority')),

                Tables\Columns\TextColumn::make('last_contact_at')
                    ->label(__('Last Contact'))
                    ->sortable()
                    ->dateTime(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->sortable()
                    ->dateTime(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
