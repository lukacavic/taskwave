<?php

namespace App\Filament\Clusters\SettingsCluster\Resources\EmailTemplateResource\Pages;

use App\Filament\Clusters\SettingsCluster\Resources\EmailTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEmailTemplates extends ManageRecords
{
    protected static string $resource = EmailTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
