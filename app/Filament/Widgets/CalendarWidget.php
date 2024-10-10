<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
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

    public function getOptions(): array
    {
        return [
            'pointer' => true,
            'firstDay' => 1,
            'nowIndicator' => true,
            'dayHeaderFormat' => ['weekday' => 'short', 'day' => 'numeric'],
        ];
    }

    public function getSchema(?string $model = null): ?array
    {
        return [
            TextInput::make('title')
                ->label(__('Title'))
        ];
    }

    public function authorize($ability, $arguments = [])
    {
        return true;
    }

    public function getEvents(array $fetchInfo = []): Collection
    {
        $start = Carbon::parse($fetchInfo['start']);
        $end = Carbon::parse($fetchInfo['end']);

        return Event::whereBetween('start_date', [$start, $end])->get();
    }
}
