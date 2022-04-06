<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ZoneCoordinate extends Model
{
    use SoftDeletes;
    
    protected $table = 'zone_coordinates';
    protected $fillable = [
        'zone_id',
        'lat',
        'lng'
    ];
}
