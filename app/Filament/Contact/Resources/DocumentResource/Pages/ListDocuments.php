<?php

namespace App\Filament\Contact\Resources\DocumentResource\Pages;

use App\Filament\Contact\Resources\DocumentResource;
use App\Models\Client;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocuments extends ListRecords
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function ($data) {
                    $data['related_type'] = Client::class;
                    $data['related_id'] = auth()->user()->client_id;

                    return $data;
                }),
        ];
    }
}
