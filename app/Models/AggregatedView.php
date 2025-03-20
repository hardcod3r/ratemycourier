<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ViewType;
class AggregatedView extends Model
{
    protected $fillable = [
        'courier_id', 'type', 'view_date', 'views'
    ];

    protected $casts = [
        'type' => ViewType::class,
        'view_date' => 'date',
        'views' => 'integer',
        'views_sum_views' => 'integer',
    ];


}
