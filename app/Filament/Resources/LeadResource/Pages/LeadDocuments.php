<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Forms\DocumentForm;
use App\Filament\Resources\ClientResource;
use App\Filament\Resources\LeadResource;
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

class LeadDocuments extends ManageRelatedRecords
{
    use HasPageSidebar;

    protected static string $resource = LeadResource::class;

    protected static string $relationship = 'documents';

    protected static ?string $navigationIcon = 'heroicon-o-paper-clip';

    public function getRecordTitle(): string|Htmlable
    {
        return __('Documents');
    }

    public function form(Form $form): Form
    {
        return DocumentForm::make($form);
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
