<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class LeadOverview extends Page implements HasInfolists
{
    use HasPageSidebar, InteractsWithRecord, InteractsWithInfolists;

    protected static string $resource = LeadResource::class;

    protected static string $view = 'filament.resources.lead-resource.pages.lead-overview';

    private static function generalInformationSection()
    {
        return Fieldset::make('General Information')
            ->columnSpan(1)
            ->columns(1)
            ->schema([
                TextEntry::make('status.name')
                    ->badge()
                    ->label(__('Status')),

                TextEntry::make('source.name')
                    ->label(__('Source')),

                TextEntry::make('assignedUser.full_name')
                    ->label(__('Assigned User'))
            ]);
    }

    private static function leadInformationSection()
    {
        return Fieldset::make('Lead Information')
            ->columnSpan(1)
            ->columns(1)
            ->schema([
                TextEntry::make('company')
            ]);
    }

    public function getTitle(): string|Htmlable
    {
        return __('Overview');
    }

    public function leadInformationInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                Grid::make(2)->schema([
                    self::leadInformationSection(),
                    self::generalInformationSection()
                ])
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('convert')
                ->label(__('Convert to client'))
                ->icon('heroicon-o-user')
                ->color('success'),

            EditAction::make()
                ->hiddenLabel()
                ->icon('heroicon-o-pencil')
                ->form(function ($form) {
                    return LeadResource::form($form);
                }),

            DeleteAction::make()
                ->hiddenLabel()
                ->icon('heroicon-o-trash')
        ];
    }

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
}
