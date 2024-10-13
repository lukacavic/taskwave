<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Tags\HasTags;

class Lead extends BaseModel
{
    use HasFactory, HasTags;

    public function fullAddress(): Attribute
    {
        return Attribute::make(function () {
            return implode(', ', [$this->address, $this->city, $this->zip_code]);
        });
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'related');
    }

    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'related');
    }

    public function tasks(): MorphMany
    {
        return $this->morphMany(Task::class, 'related');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(LeadStatus::class, 'status_id');
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(LeadSource::class, 'source_id');
    }
}
