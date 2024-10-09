<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class ProjectOverview extends Page
{
    use HasPageSidebar, InteractsWithRecord;

    protected static string $resource = ProjectResource::class;

    protected static string $view = 'filament.resources.project-resource.pages.project-overview';

    public function getTitle(): string|Htmlable
    {
        return __('Overview');
    }

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
}
