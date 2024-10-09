<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Document extends BaseModel implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function related(): MorphTo
    {
        return $this->morphTo();
    }
}
