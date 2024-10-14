<?php

namespace App\Models;

use App\TicketStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class Ticket extends BaseModel implements HasMedia
{
    use HasFactory, HasTags, InteractsWithMedia;

    protected static function booted(): void
    {
        parent::booted();

        static::creating(function ($ticket) {
            $ticket->status_id = TicketStatus::Open;
        });
    }

    public function creatorName(): Attribute
    {
        return Attribute::make(function () {
            if ($this->contact_id != null) {
                return $this->contact->full_name;
            }

            return $this->user->full_name;
        });
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function tasks(): MorphMany
    {
        return $this->morphMany(Task::class, 'related');
    }

    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'related');
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(TicketDepartment::class, 'department_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class, 'ticket_id');
    }
}
