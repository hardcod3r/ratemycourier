<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Traits\HasManyRatesTrait;
use App\Models\Traits\HasManyViewsTrait;
use App\Models\Scopes\CourierScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Courier extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUuids;
    use HasManyRatesTrait;
    use HasManyViewsTrait;
    use CourierScopes;

    protected $keyType = 'string';
    public $incrementing = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    protected $casts = [
        'id' => 'string',
        'sum_views' => 'integer',
    ];
}
