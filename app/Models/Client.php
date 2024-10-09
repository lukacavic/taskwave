<?php

namespace App\Models;

use App\Models\Traits\Organisationable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Client extends BaseModel
{
    use HasFactory;

    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'related');
    }
}
