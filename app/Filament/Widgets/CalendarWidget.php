<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\Reservation;
use Awcodes\Palette\Forms\Components\ColorPicker;
use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Support\Colors\Color;
use Guava\Calendar\Actions\CreateAction;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class CalendarWidget extends \Guava\Calendar\Widgets\CalendarWidget
{
    protected static ?int $sort = 5;
    protected bool $eventClickEnabled = true;
    protected bool $eventResizeEnabled = false;
    protected bool $eventDragEnabled = false;
    protected bool $noEventsClickEnabled = true;
    protected bool $dateClickEnabled = true;
    protected ?string $defaultEventClickAction = 'edit';

    protected string|Closure|HtmlString|null $heading = '';

    protected string $calendarView = 'timeGridWeek';

    public function getOptions(): array
    {
        return [
            'pointer' => true,
            'firstDay' => 1,
            'nowIndicator' => true,
            'dayHeaderFormat' => ['weekday' => 'short', 'day' => 'numeric'],
            'headerToolbar' => [
                'start' => 'title',
                'center' => 'timeGridDay, timeGridWeek, dayGridMonth',
                'end' => 'today prev,next',
            ],
            'buttonText' => [
                'timeGridDay' => 'Today',
                'timeGridWeek' => 'Week',
                'dayGridMonth' => 'Month',
                'today' => 'Today'
            ]
        ];
    }

    public function getDateClickContextMenuActions(): array
    {
        return [
            CreateAction::make('new-event')
                ->label(__('New event'))
                ->modalHeading(__('New event'))
                ->model(Event::class)
                ->mountUsing(function ($arguments, Form $form) {
                    return $form->fill([
                        'start_date' => data_get($arguments, 'dateStr'),
                    ]);
                })
        ];
    }

    public function getSchema(?string $model = null): ?array
    {
        return [
            TextInput::make('name')
                ->required()
                ->label(__('Title')),

            RichEditor::make('description')
                ->label(__('Description')),

            Split::make([
                DateTimePicker::make('start_date')
                    ->required()
                    ->default(now())
                    ->label(__('Start date')),

                DateTimePicker::make('end_date')
                    ->label(__('End date')),
            ]),

            ColorPicker::make('color')
                ->colors([
                    'indigo' => Color::Indigo,
                    'badass' => Color::hex('#bada55'),
                    'salmon' => '#fa8072',
                    'bg-gradient-secondary' => 'bg-gradient-secondary'
                ])
                ->storeAsKey()
                ->shades([
                    'badass' => 300
                ])
                ->size('sm')
                ->withBlack(swap: '#111111')
                ->withWhite(swap: '#f5f5f5'),

            Checkbox::make('public')
                ->label(__('Public'))

        ];
    }

    public function authorize($ability, $arguments = [])
    {
        return true;
    }

    public function getEvents(array $fetchInfo = []): array|Collection
    {
        $start = Carbon::parse($fetchInfo['start']);
        $end = Carbon::parse($fetchInfo['end']);

        return Event::whereBetween('start_date', [$start, $end])->get();
    }
}
