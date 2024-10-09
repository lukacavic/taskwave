<?php

namespace App\Filament\Clusters\SettingsCluster\Resources\ClientGroupResource\Pages;

use App\Filament\Clusters\SettingsCluster\Resources\ClientGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageClientGroups extends ManageRecords
{
    protected static string $resource = ClientGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
