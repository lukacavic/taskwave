<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Imports\LeadImportImporter;
use App\Filament\Resources\LeadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Alignment;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalAlignment(Alignment::Left)
                ->modalIcon('heroicon-o-user-plus')
                ->modalDescription('Add new lead'),

            Actions\ImportAction::make()
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(LeadImportImporter::class),

            Actions\Action::make('kanban')
                ->hiddenLabel()
                ->icon('heroicon-o-square-3-stack-3d')

        ];
    }
}
