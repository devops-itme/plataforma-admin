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
        'neighborhood_id',
        'package_type',
        'estimated_time',
        'extra_for_weight',
        'extra_per_size',
        'percentage_immediate_delivery',
        'special_rate',
        'state'
    ];

    public function getZone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }
    public function getNeighborhood()
    {
        return $this->belongsTo(Neighborhood::class, 'neighborhood_id');
    }
    public function getPackageType()
    {
        return $this->belongsTo(ParameterValue::class, 'package_type');
    }
}
