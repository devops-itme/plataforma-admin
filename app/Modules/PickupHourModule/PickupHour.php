<?php

namespace App\Modules\PickupHourModule;

use App\Modules\ParameterValueModule\ParameterValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PickupHour extends Model
{
    use SoftDeletes;
    protected $table = 'pickup_hours';
    protected $fillable = [
        'day_id',
        'init_time',
        'end_time',
    ];

    public function getDay()
    {
        return $this->belongsTo(ParameterValue::class, 'day_id');
    }

}
