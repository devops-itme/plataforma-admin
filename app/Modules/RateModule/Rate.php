<?php

namespace App\Modules\RateModule;

use App\Modules\NeighborhoodModule\Neighborhood;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\ZoneModule\Zone;
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
        'base_value',
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

    public function scopePackageType($query, $value)
    {
        if (!is_null($value))
            $query->where('package_type',  $value);
    }

    public function scopeBaseValue($query, $value)
    {
        if (!is_null($value))
            $query->where('base_value',  $value);
    }

    public function scopeZone($query, $value)
    {
        if (!is_null($value))
            $query->where('zone_id',  $value);
    }

    public function scopeNeighborhood($query, $value)
    {
        if (!is_null($value))
            $query->where('neighborhood_id',  $value);
    }

    public function scopeState($query, $value)
    {
        if (!is_null($value))
            $query->where('state', $value);
    }


    public function calculateRate($rate_id, $lbs, $vol, $immediate_delivery = false)
    {
        $calculated = null;
        $rate = $this::where('id', $rate_id)->first();
        $calculated = $rate->base_value;
        switch ($rate->getPackageType->name) {
            case 'Tipo A':
                if ($lbs > 50) {
                    $calculated += $lbs > $vol ? $rate->extra_for_weight * $lbs : $rate->extra_per_size * $vol;
                }
                break;
            case 'Tipo B':
                if ($lbs > 66) {
                    $calculated += $lbs > $vol ? $rate->extra_for_weight * $lbs : $rate->extra_per_size * $vol;
                }
                break;
            default:
                $calculated = 0;
                break;
        }

        if ($immediate_delivery) {
            $calculated += ($calculated * $rate->percentage_immediate_delivery / 100);
        }

        return $calculated;
    }
}
