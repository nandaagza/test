<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;

class Branch extends BaseModel
{
    protected $fillable = [
        'name',
        'department_id',
    ];

    protected $casts =[
        'department_id' => 'array'
    ];

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }
}
