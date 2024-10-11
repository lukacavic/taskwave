<?php

namespace App\Filament\Contact\Resources\DocumentResource\Pages;

use App\Filament\Contact\Resources\DocumentResource;
use App\Models\Client;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

}
