<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    use SoftDeletes;
    protected $table = 'rates';
    protected $fillable = [
        'zone_id',
        'package_type',
        'estimated_time',
        'extra_for_weight',
        'extra_per_size',
        'percentage_immediate_delivery',
        'special_rate',
        'state'
    ];
}
