<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Models\TicketPredefinedReply;
use App\TicketStatus;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Split;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\ActionSize;
use Illuminate\Contracts\Support\Htmlable;

class ViewTicket extends Page implements HasForms
{
    use InteractsWithForms, InteractsWithRecord;

    protected static string $resource = TicketResource::class;

    protected static string $view = 'filament.resources.ticket-resource.pages.view-ticket';

    public string $activeTab = 'reply';

    public ?array $replyFormData = [];

    public function getTitle(): string|Htmlable
    {
        return '#' . $this->record->id . ' - ' . $this->record->subject;
    }

    public function replyForm(Form $form): Form
    {
        return $form
            ->statePath('replyFormData')
            ->schema([
                Section::make()
                    ->schema([
                        Split::make([
                            Select::make('predefined_reply')
                                ->options(TicketPredefinedReply::get()->pluck('name', 'id'))
                                ->placeholder(__('Insert predefined reply')),
                            Select::make('knowledge_base')
                                ->placeholder(__('Insert knowledge base article')),

                        ]),

                        RichEditor::make('reply')
                            ->required()
                            ->placeholder(__('Insert Reply'))
                            ->label(__('Reply')),

                        Select::make('status_id')
                            ->required()
                            ->options(TicketStatus::class)
                            ->label(__('Change Status')),

                        SpatieMediaLibraryFileUpload::make('attachments')
                            ->multiple()
                            ->label(__('Attachments'))
                            ->downloadable()
                    ])
            ]);
    }

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->fillForms();
    }

    private function fillForms(): void
    {
        $this->replyForm->fill();
    }

    public function saveReply()
    {
        $data = $this->getForm('replyForm')->getState();

        dd($data);
    }

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('test')
            ])->label('Open')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size(ActionSize::Small)
                ->color('danger')
                ->button()
        ];
    }

    protected function getForms(): array
    {
        return [
            'replyForm',
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('Save'))
                ->submit('saveReply'),
        ];
    }

}
