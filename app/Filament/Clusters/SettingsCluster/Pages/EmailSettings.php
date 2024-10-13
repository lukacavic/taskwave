<?php

namespace App\Filament\Clusters\SettingsCluster\Pages;

use App\Filament\Clusters\SettingsCluster;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;
use Filament\Support\Exceptions\Halt;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class EmailSettings extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-at-symbol';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.clusters.settings-cluster.pages.email-settings';

    protected static ?string $cluster = SettingsCluster::class;

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public function mount(): void
    {
        $this->form->fill(auth()->user()->organisation->settings()->all());
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
                Section::make()
                    ->key('email-settings')
                    ->footerActions([
                        self::getSendTestEmailAction()
                    ])
                    ->footerActionsAlignment(Alignment::End)
                    ->columns(2)
                    ->schema([
                        ToggleButtons::make('email_enabled')
                            ->boolean(__('Yes'), __('No'))
                            ->label(__('Enable SMTP integration'))
                            ->default(false)
                            ->reactive()
                            ->columnSpanFull()
                            ->inline(),

                        Split::make([
                            TextInput::make('smtp_server')
                                ->placeholder('mail.example.com')
                                ->disabled(function (Get $get) {
                                    return !$get('email_enabled');
                                })
                                ->required(function (Get $get) {
                                    return $get('email_enabled');
                                })
                                ->label('SMTP Server'),

                            TextInput::make('smtp_port')
                                ->placeholder('2525')
                                ->disabled(function (Get $get) {
                                    return !$get('email_enabled');
                                })
                                ->required(function (Get $get) {
                                    return $get('email_enabled');
                                })
                                ->numeric()
                                ->label('SMTP Port'),

                        ]),
                        ToggleButtons::make('smtp_encryption')
                            ->default('tls')
                            ->label(__('Encryption'))
                            ->disabled(function (Get $get) {
                                return !$get('email_enabled');
                            })
                            ->required(function (Get $get) {
                                return $get('email_enabled');
                            })
                            ->inline()
                            ->options([
                                'no-encryption' => __('No encryption'),
                                'ssl' => 'SSL',
                                'tls' => 'TLS'
                            ]),

                        Split::make([
                            TextInput::make('smtp_username')
                                ->placeholder('example@example.com')
                                ->disabled(function (Get $get) {
                                    return !$get('email_enabled');
                                })
                                ->required(function (Get $get) {
                                    return $get('email_enabled');
                                })
                                ->label(__('SMTP Username')),

                            TextInput::make('smtp_password')
                                ->password()
                                ->disabled(function (Get $get) {
                                    return !$get('email_enabled');
                                })
                                ->required(function (Get $get) {
                                    return $get('email_enabled');
                                })
                                ->revealable()
                                ->label(__('SMTP Password')),
                        ])->columnSpan(2),

                        Split::make([
                            TextInput::make('smtp_from')
                                ->placeholder('example@example.com')
                                ->disabled(function (Get $get) {
                                    return !$get('email_enabled');
                                })
                                ->required(function (Get $get) {
                                    return $get('email_enabled');
                                })
                                ->label(__('From'))
                                ->email(),

                            TextInput::make('smtp_from_name')
                                ->placeholder('John Doe')
                                ->disabled(function (Get $get) {
                                    return !$get('email_enabled');
                                })
                                ->required(function (Get $get) {
                                    return $get('email_enabled');
                                })
                                ->label(__('From Name')),
                        ])->columnSpan(2)
                    ])

            ])
            ->statePath('data');
    }

    public function getSendTestEmailAction(): \Filament\Forms\Components\Actions\Action
    {
        return \Filament\Forms\Components\Actions\Action::make('test-email-settings')
            ->label('Send Test Email')
            ->outlined()
            ->icon('heroicon-o-at-symbol')
            ->disabled(function (Get $get) {
                return $get('smtp_server') == null || $get('smtp_port') == null;
            })
            ->action(function ($data, Get $get) {
                try {
                    config()->set('mail.default', 'smtp');
                    config()->set('mail.mailers.smtp.host', $get('smtp_server'));
                    config()->set('mail.mailers.smtp.port', $get('smtp_port'));
                    config()->set('mail.mailers.smtp.username', $get('smtp_username'));
                    config()->set('mail.mailers.smtp.password', $get('smtp_password'));
                    config()->set('mail.mailers.smtp.encryption', $get('smtp_encryption'));

                    config()->set('mail.from.name', $get('smtp_from_name'));
                    config()->set('mail.from.address', $get('smtp_from'));

                    Mail::raw($data['body'], function (Message $msg) use ($data) {
                        $msg->to($data['to'])
                            ->subject($data['subject']);
                    })->getDebug();

                } catch (Exception $e) {
                    Notification::make()
                        ->danger()
                        ->title(__('Error sending email'))
                        ->body($e->getMessage())
                        ->send();

                    $this->halt();
                }

                Notification::make()
                    ->success()
                    ->title(__('Email sent'))
                    ->send();

            })
            ->form(function ($form) {
                return $form->schema([
                    TextInput::make('to')
                        ->label(__('To'))
                        ->required()
                        ->email(),

                    TextInput::make('subject')
                        ->label(__('Subject'))
                        ->required(),

                    Textarea::make('body')
                        ->label(__('Body'))
                        ->required(),
                ]);
            });
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            foreach ($data as $key => $value) {
                auth()->user()->organisation->settings()->update($key, $value);
            }

            Notification::make()
                ->success()
                ->title(__('Saved'))
                ->send();
        } catch (Halt $exception) {
            return;
        }
    }
}
