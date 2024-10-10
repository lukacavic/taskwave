<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends BaseModel
{
    use HasFactory;

    public function type()
    {
        return $this->belongsTo(ContractType::class, 'type_id');
    }
}
