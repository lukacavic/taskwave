<?php

namespace App\Models;

use Guava\Calendar\Contracts\Eventable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends BaseModel implements Eventable
{
    use HasFactory;

    public function toEvent(): array|\Guava\Calendar\ValueObjects\Event
    {
        return \Guava\Calendar\ValueObjects\Event::make($this)
            ->key($this->id)
            ->title($this->name)
            ->start($this->start_date)
            ->end($this->end_date);
    }
}
