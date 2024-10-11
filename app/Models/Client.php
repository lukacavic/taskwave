<?php

namespace App\Models;

use App\Models\Traits\Organisationable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends BaseModel
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return LogOptions::defaults();
    }

    public function fullAddress(): Attribute
    {
        return Attribute::make(function () {
            return implode(', ', [$this->address, $this->city, $this->zip_code]);
        });
    }

    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'related');
    }

    public function tasks(): MorphMany
    {
        return $this->morphMany(Task::class, 'related');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'client_id');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'client_id');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'related');
    }
}
