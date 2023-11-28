<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Township extends Model
{
    use HasFactory,HasUlids;

    public function quarters(){
        return $this->hasMany(Quarter::class);
    }

    public function region(){
        return $this->belongsTo(Region::class);
    }
}
