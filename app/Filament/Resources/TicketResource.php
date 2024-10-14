<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages\LeadOverview;
use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use App\TicketPriority;
use App\TicketStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Main information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('subject')
                            ->label(__('Subject'))
                            ->required(),

                        Forms\Components\Select::make('contact_id')
                            ->label(__('Contact'))
                            ->searchable()
                            ->relationship('contact', 'first_name')
                            ->required(),

                        Forms\Components\Select::make('department_id')
                            ->label(__('Department'))
                            ->preload()
                            ->relationship('department', 'name')
                            ->required(),

                        Forms\Components\Select::make('assigned_user_id')
                            ->relationship('assignedUser', 'name')
                            ->label(__('Assigned User')),

                        Forms\Components\Select::make('priority_id')
                            ->options(TicketPriority::class)
                            ->required()
                            ->default(TicketPriority::Normal->value)
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
            ->recordUrl(
                fn(Model $record): string => Pages\ViewTicket::getUrl([$record->id]),
            )
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
                    ->formatStateUsing(function ($state) {
                        return TicketStatus::from($state)->getLabel();
                    })
                    ->badge(),

                Tables\Columns\TextColumn::make('priority_id')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return TicketStatus::from($state)->getLabel();
                    })
                    ->label(__('Priority')),

                Tables\Columns\TextColumn::make('last_reply_at')
                    ->label(__('Last Reply'))
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
            'view' => Pages\ViewTicket::route('/{record}/view'),
        ];
    }
}
