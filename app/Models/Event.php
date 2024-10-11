<?php

namespace App\Models;

use Guava\Calendar\Contracts\Eventable;
use Guava\Calendar\ValueObjects\Event as CalendarEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends BaseModel implements Eventable
{
    use HasFactory;

    protected $casts = [
        'color' => 'array'
    ];

    public function toEvent(): array|CalendarEvent
    {
        return CalendarEvent::make($this)
            ->key($this->id)
            ->backgroundColor($this->color ?? null)
            ->title($this->name)
            ->allDay($this->end_date == null)
            ->start($this->start_date)
            ->end($this->end_date ?? $this->start_date);
    }
}
