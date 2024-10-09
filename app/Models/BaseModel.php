<?php

namespace App\Models;

use App\Models\Traits\Organisationable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use Organisationable, SoftDeletes;

    protected $guarded = ['id'];
}
