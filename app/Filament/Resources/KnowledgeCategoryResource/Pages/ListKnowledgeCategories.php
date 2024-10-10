<?php

namespace App\Filament\Resources\KnowledgeCategoryResource\Pages;

use App\Filament\Resources\KnowledgeCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKnowledgeCategories extends ListRecords
{
    protected static string $resource = KnowledgeCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
