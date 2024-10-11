<?php

namespace App\Filament\Contact\Resources\ContractResource\Pages;

use App\Filament\Contact\Resources\ContractResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContracts extends ListRecords
{
    protected static string $resource = ContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(false)
                ->disabled(true),
        ];
    }

}
