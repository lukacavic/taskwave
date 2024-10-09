<?php

namespace App\Filament\Clusters\SettingsCluster\Resources\LeadStatusResource\Pages;

use App\Filament\Clusters\SettingsCluster\Resources\LeadStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLeadStatuses extends ManageRecords
{
    protected static string $resource = LeadStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
