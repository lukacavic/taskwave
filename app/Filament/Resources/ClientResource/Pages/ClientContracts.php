<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Filament\Resources\ContractResource;
use App\Filament\Resources\TaskResource;
use App\Models\Document;
use App\Models\Task;
use App\TaskStatus;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ClientContracts extends ManageRelatedRecords
{
    use HasPageSidebar;

    protected static string $resource = ClientResource::class;

    protected static string $relationship = 'contracts';

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    public function getRecordTitle(): string|Htmlable
    {
        return __('Contracts');
    }

    public function form(Form $form): Form
    {
        return ContractResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->label(__('Subject')),

                Tables\Columns\TextColumn::make('client.name')
                    ->sortable()
                    ->searchable()
                    ->label(__('Client')),

                Tables\Columns\TextColumn::make('type.name')
                    ->badge()
                    ->sortable()
                    ->label(__('Type')),

                Tables\Columns\TextColumn::make('contract_value')
                    ->label(__('Contract Value'))
                    ->sortable()
                    ->money('EUR'),

                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable()
                    ->label(__('Start Date')),

                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable()
                    ->label(__('End Date')),
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
