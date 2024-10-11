<?php

namespace App\Filament\Contact\Resources\TicketResource\Pages;

use App\Filament\Contact\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['contact_id'] = auth()->id();

        return $data;
    }
}
