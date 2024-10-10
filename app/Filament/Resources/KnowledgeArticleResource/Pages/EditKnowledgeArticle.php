<?php

namespace App\Filament\Resources\KnowledgeArticleResource\Pages;

use App\Filament\Resources\KnowledgeArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKnowledgeArticle extends EditRecord
{
    protected static string $resource = KnowledgeArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
