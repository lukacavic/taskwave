<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EmailTemplate extends BaseModel implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function scopeForType(Builder $query, $typeId): void
    {
        $query->where('type_id', $typeId);
    }
}
