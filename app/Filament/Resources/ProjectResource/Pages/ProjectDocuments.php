<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Filament\Resources\ProjectResource;
use App\Models\Document;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectDocuments extends ManageRelatedRecords
{
    use HasPageSidebar;

    protected static string $resource = ProjectResource::class;

    protected static string $relationship = 'documents';

    protected static ?string $navigationIcon = 'heroicon-o-paper-clip';

    public function getRecordTitle(): string|Htmlable
    {
        return __('Documents');
    }

    public function form(Form $form): Form
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }
}
