<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends BaseModel
{
    protected $fillable = [
        'address',
        'region_id',
        'township_id',
        'quarter_id',
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
