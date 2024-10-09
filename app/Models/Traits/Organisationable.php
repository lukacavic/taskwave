<?php

namespace App\Models\Traits;

use App\Models\Organisation;
use App\Models\Scopes\OrganisationScope;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

trait Organisationable
{
    public static function bootOrganisationable(): void
    {
        if (auth()->check()) {
            static::addGlobalScope(new OrganisationScope());

            static::creating(function ($model) {
                $model->organisation_id = auth()->user()->organisation_id;

                if (Schema::hasColumn($model->getTable(), 'user_id')) {
                    $model->user_id = auth()->id();
                }

            });
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }
}
