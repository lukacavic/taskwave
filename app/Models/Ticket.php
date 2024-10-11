<?php

namespace App\Models;

use App\TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class Ticket extends BaseModel implements HasMedia
{
    use HasFactory, HasTags, InteractsWithMedia;

    protected static function booted()
    {
        parent::booted();

        static::created(function ($ticket) {
            $ticket->status_id = TicketStatus::OPEN;
        });
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(TicketDepartment::class, 'department_id');
    }
}
