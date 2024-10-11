<?php

namespace App\Filament\Contact\Resources\TicketResource\Pages;

use App\Filament\Contact\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Open Ticket'),
        ];
    }
}
