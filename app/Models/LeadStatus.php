<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeadStatus extends BaseModel
{
    use HasFactory;

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'status_id');
    }
}
