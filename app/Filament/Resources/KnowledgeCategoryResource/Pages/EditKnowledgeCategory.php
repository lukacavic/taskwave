<?php

namespace App\Filament\Resources\KnowledgeCategoryResource\Pages;

use App\Filament\Resources\KnowledgeCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKnowledgeCategory extends EditRecord
{
    protected static string $resource = KnowledgeCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
