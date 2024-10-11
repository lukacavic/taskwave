<?php

namespace App\Filament\Contact\Resources;

use App\Filament\Contact\Resources\DocumentResource\Pages;
use App\Filament\Contact\Resources\DocumentResource\RelationManagers;
use App\Models\Client;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\MediaLibrary\Support\MediaStream;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-clip';

    protected static bool $isScopedToTenant = false;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required()
                    ->maxLength(255),

                Forms\Components\SpatieMediaLibraryFileUpload::make('attachments')
                    ->multiple()
                    ->required()
                    ->label(__('Attachments'))
                    ->downloadable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHasMorph('related', [Client::class], function (Builder $query) {
                    return $query->where('id', auth()->user()->client_id);
                });
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->description(function (Document $record) {
                        return __('Total ') . $record->media()->count() . __(' documents');
                    })
                    ->label(__('Name')),

                Tables\Columns\TextColumn::make('user.full_name')
                    ->searchable()
                    ->sortable()
                    ->label(__('Created by')),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->description(function (Document $record) {
                        return $record->created_at->diffForHumans();
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label(__('Download'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Document $record, $data) {
                        $downloads = $record->getMedia();

                        return MediaStream::create('attachments.zip')->addMedia($downloads);
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListDocuments::route('/'),
            //'create' => Pages\CreateDocument::route('/create'),
            //'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
