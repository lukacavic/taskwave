<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketReply extends BaseModel
{
    use HasFactory;

    public function creatorName(): Attribute
    {
        return Attribute::make(function () {
            if ($this->contact_id != null) {
                return $this->contact->full_name;
            }

            return $this->user->full_name;
        });
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
