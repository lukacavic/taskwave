<?php

namespace App\Models\Traits;

use App\Models\Organisation;
use App\Models\Scopes\OrganisationScope;
use App\Models\User;

trait Organisationable
{
    public static function bootOrganisationable(): void
    {
       if(auth()->check()) {
           static::addGlobalScope(new OrganisationScope());

           static::creating(function ($model) {
               $model->organisation_id = auth()->user()->organisation_id;
               $model->user_id = auth()->id();
           });
       }
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
