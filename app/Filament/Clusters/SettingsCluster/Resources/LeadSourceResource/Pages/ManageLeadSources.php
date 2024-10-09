<?php

namespace App\Filament\Clusters\SettingsCluster\Resources\LeadSourceResource\Pages;

use App\Filament\Clusters\SettingsCluster\Resources\LeadSourceResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLeadSources extends ManageRecords
{
    protected static string $resource = LeadSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
