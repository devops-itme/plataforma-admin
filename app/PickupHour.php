<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PickupHour extends Model
{
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
