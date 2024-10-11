<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Filament\Resources\ContactResource;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class ClientContacts extends ManageRelatedRecords
{
    use HasPageSidebar;

    protected static string $resource = ClientResource::class;

    protected static string $relationship = 'contacts';

    public function getTitle(): string|Htmlable
    {
        return __('Contacts');
    }

    public function form(Form $form): Form
    {
        return ContactResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name')),

                TextColumn::make('position')
                    ->label(__('Position')),

                ToggleColumn::make('active')
                    ->label(__('Active')),

                TextColumn::make('email')
                    ->label(__('Email')),

                TextColumn::make('phone')
                    ->label(__('Phone')),

                TextColumn::make('last_login_at')
                    ->label(__('Last Login at'))
                    ->dateTime()
            ])
            ->headerActions([
                CreateAction::make()
                    ->modalAlignment(Alignment::Left)
                    ->modalIcon('heroicon-o-user-plus')
                    ->modalDescription('Add new contact'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }
}
