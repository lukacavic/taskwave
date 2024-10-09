<?php

namespace App\Filament\Clusters\SettingsCluster\Resources\TicketSpamFilterResource\Pages;

use App\Filament\Clusters\SettingsCluster\Resources\TicketSpamFilterResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTicketSpamFilters extends ManageRecords
{
    protected static string $resource = TicketSpamFilterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
