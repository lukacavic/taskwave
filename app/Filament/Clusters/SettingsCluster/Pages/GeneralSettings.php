<?php

namespace App\Filament\Clusters\SettingsCluster\Pages;

use App\Filament\Clusters\SettingsCluster;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;

class GeneralSettings extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.clusters.settings-cluster.pages.general-settings';

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 30;

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public function mount(): void
    {
        $this->form->fill(auth()->user()->organisation->attributesToArray());
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('Save'))
                ->submit('save'),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    FileUpload::make('logo')
                        ->placeholder(__('Load your company logo'))
                        ->label('Logo')
                        ->downloadable()
                        ->columnSpanFull(),

                    TextInput::make('name')
                        ->label(__('Company name'))
                        ->required(),

                    SpatieTagsInput::make('allowed_files')
                        ->label(__('Allowed file types'))
                ])

            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            auth()->user()->organisation->update($data);

            Notification::make()
                ->success()
                ->title("Spremljeno.")
                ->send();
        } catch (Halt $exception) {
            return;
        }
    }
}
