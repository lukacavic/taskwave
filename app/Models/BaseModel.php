<?php

namespace App\Models;

use App\Models\Traits\Organisationable;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use Organisationable;

    protected $guarded = ['id'];
}
