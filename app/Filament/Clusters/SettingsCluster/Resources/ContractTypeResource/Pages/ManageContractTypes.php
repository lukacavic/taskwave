<?php

namespace App\Filament\Clusters\SettingsCluster\Resources\ContractTypeResource\Pages;

use App\Filament\Clusters\SettingsCluster\Resources\ContractTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageContractTypes extends ManageRecords
{
    protected static string $resource = ContractTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
