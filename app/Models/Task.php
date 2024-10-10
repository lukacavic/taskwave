<?php

namespace App\Models;

use App\TaskStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class Task extends BaseModel implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTags;

    protected static function booted(): void
    {
        parent::booted();

        static::creating(function (Model $model) {
            $model->status_id = 1;
        });

    }

    public function scopeNotCompleted(Builder $query): void
    {
        $query->whereNot('status_id', TaskStatus::Completed->value);
    }

    public function scopeCompleted(Builder $query): void
    {
        $query->where('status_id', TaskStatus::Completed->value);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'link_task_users');
    }

    public function related(): MorphTo
    {
        return $this->morphTo();
    }

}
