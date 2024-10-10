<?php

namespace App\Filament\Resources\KnowledgeArticleResource\Pages;

use App\Filament\Resources\KnowledgeArticleResource;
use App\Filament\Resources\KnowledgeCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKnowledgeArticles extends ListRecords
{
    protected static string $resource = KnowledgeArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('categories')
                ->hiddenLabel()
                ->url(function () {
                    return KnowledgeCategoryResource::getUrl('index');
                })
                ->tooltip('Kategorije')
                ->icon('heroicon-o-tag'),
        ];
    }
}
