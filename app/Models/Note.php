<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Note extends BaseModel
{
    use HasFactory;

    public function related(): MorphTo
    {
        return $this->morphTo();
    }
}
