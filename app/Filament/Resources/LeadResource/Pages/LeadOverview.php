<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use App\Models\Lead;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use CodeWithDennis\SimpleAlert\Components\Infolists\SimpleAlert;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Placeholder;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\SpatieTagsEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

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
                    ->label(__('Assigned User')),

                SpatieTagsEntry::make('tags')
                    ->label(__('Tags')),

                TextEntry::make('created_at')
                    ->dateTime()
                    ->since()
                    ->label(__('Created At')),
            ]);
    }

    private static function leadInformationSection()
    {
        return Fieldset::make('Lead Information')
            ->columnSpan(1)
            ->columns(1)
            ->schema([
                TextEntry::make('name')
                    ->label(__('Name')),

                TextEntry::make('position')
                    ->label(__('Position')),

                TextEntry::make('email')
                    ->label(__('Email')),

                TextEntry::make('phone')
                    ->label(__('Phone')),

                TextEntry::make('website')
                    ->label(__('Website')),

                TextEntry::make('full_address')
                    ->label(__('Address')),
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
                    SimpleAlert::make('junk-notification')
                        ->danger()
                        ->border(true)
                        ->columnSpanFull()
                        ->title(__('This lead is marked as junk'))
                        ->visible(function (Lead $record) {
                            return $record->junk;
                        }),

                    SimpleAlert::make('lost-notification')
                        ->warning()
                        ->border(true)
                        ->columnSpanFull()
                        ->title(__('This lead is marked as lost'))
                        ->visible(function (Lead $record) {
                            return $record->lost;
                        }),

                    self::leadInformationSection(),

                    self::generalInformationSection(),

                    TextEntry::make('description')
                        ->columnSpanFull()
                        ->label(__('Description')),
                ])
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('mark-as-lost')
                    ->visible(function (Lead $record) {
                        return !$record->junk;
                    })
                    ->action(function () {
                        $this->record->update([
                            'lost' => !$this->record->lost
                        ]);
                    })
                    ->icon('heroicon-o-archive-box-arrow-down')
                    ->label(function (Lead $record) {
                        return $record->lost ? __('Unmark as lost') : __('Mark as lost');
                    }),

                Action::make('mark-as-junk')
                    ->visible(function (Lead $record) {
                        return !$record->lost;
                    })
                    ->action(function () {
                        $this->record->update([
                            'junk' => !$this->record->junk
                        ]);
                    })
                    ->icon('heroicon-o-archive-box-x-mark')
                    ->label(function (Lead $record) {
                        return $record->junk ? __('Unmark as junk') : __('Mark as junk');
                    }),

                DeleteAction::make()
                    ->icon('heroicon-o-trash')
            ])->label(__('More'))
                ->color('gray')
                ->button(),


        ];
    }

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
}
