<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class ClientOverview extends Page
{
    use HasPageSidebar, InteractsWithRecord;

    protected static string $resource = ClientResource::class;

    protected static string $view = 'filament.resources.client-resource.pages.client-overview';

    public function getTitle(): string|Htmlable
    {
        return __('Overview');
    }

    public function like()
    {
        dd("e");
    }
    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
}
