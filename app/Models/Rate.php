<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\RateType;

class Rate extends Model
{

    protected $fillable = [
        'rate', 'user_id', 'courier_id'
    ];


    protected $casts = [
        'rate' => RateType::class,
    ];
}
