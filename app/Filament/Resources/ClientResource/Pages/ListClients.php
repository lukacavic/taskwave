<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClients extends ListRecords
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderWidgets(): array
    {
        return [ClientResource\Widgets\ClientStats::class];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\ImportAction::make('import')
                ->icon('heroicon-o-arrow-up-tray')
                ->label(__('Import clients')),

            Actions\Action::make('contacts')
                ->label(__('Contacts'))
                ->color('gray')
                ->icon('heroicon-o-user')
        ];
    }
}
