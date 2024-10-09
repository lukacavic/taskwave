<?php

namespace App\Filament\Clusters\SettingsCluster\Resources\TicketPredefinedReplyResource\Pages;

use App\Filament\Clusters\SettingsCluster\Resources\TicketPredefinedReplyResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTicketPredefinedReplies extends ManageRecords
{
    protected static string $resource = TicketPredefinedReplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
