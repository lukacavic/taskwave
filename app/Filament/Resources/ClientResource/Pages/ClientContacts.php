<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Filament\Resources\ContactResource;
use App\Models\Contact;
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
                TextColumn::make('full_name')
                    ->sortable()
                    ->searchable()
                    ->description(function (Contact $record) {
                        return $record->position;
                    })
                    ->label(__('Full Name')),

                TextColumn::make('client.name')
                    ->sortable()
                    ->searchable()
                    ->label(__('Client')),

                ToggleColumn::make('active')
                    ->label(__('Active')),

                TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->label(__('Email')),

                TextColumn::make('phone')
                    ->sortable()
                    ->searchable()
                    ->label(__('Phone')),


                TextColumn::make('last_login_at')
                    ->dateTime()
                    ->description(function (Contact $record) {
                        return $record->last_login_at->diffForHumans() ?? null;
                    })
                    ->label(__('Last Login')),
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
