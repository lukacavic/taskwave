<?php

namespace App\Filament\Contact\Resources;

use App\Filament\Contact\Resources\TicketResource\Pages;
use App\Filament\Contact\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use App\TicketPriority;
use App\TicketStatus;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('subject')
                    ->label(__('Subject'))
                    ->required(),

                Forms\Components\Split::make([
                    Forms\Components\Select::make('department_id')
                        ->label(__('Department'))
                        ->relationship('department', 'name')
                        ->required(),

                    Forms\Components\Select::make('priority_id')
                        ->label(__('Priority'))
                        ->required()
                        ->options(TicketPriority::class)
                        ->default(TicketPriority::Normal->value)
                ]),

                Forms\Components\RichEditor::make('body')
                    ->required()
                    ->label(__('Body')),

                SpatieMediaLibraryFileUpload::make('attachments')
                    ->collection('ticket-attachment')
                    ->multiple()
                    ->label(__('Attachments'))
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('contact_id', auth()->id());
            })
            ->columns([
                Tables\Columns\TextColumn::make('subject')
                    ->label(__('Subject'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('department.name')
                    ->label(__('Department'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('status_id')
                    ->label(__('Status'))
                    ->formatStateUsing(function ($state) {
                        return TicketStatus::from($state)->getLabel();
                    })
                    ->badge(),

                Tables\Columns\TextColumn::make('priority_id')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        return TicketPriority::from($state)->getLabel();
                    })
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
