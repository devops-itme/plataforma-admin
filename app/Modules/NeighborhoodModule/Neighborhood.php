<?php

namespace App\Modules\NeighborhoodModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Neighborhood extends Model
{
    use SoftDeletes;

    protected $table = 'neighborhoods';
    protected $primaryKey = 'id';
    protected $fillable = [
        'corregimiento_id',
        'zone_id',
        'name',
        'state'
    ];

    public function getCorregimiento()
    {
        return $this->belongsTo(Corregimiento::class, 'corregimiento_id');
    }

    public function getZone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    } 

    public function scopeCorregimiento($query, $value)
    {
        if (!is_null($value))
            $query->where('corregimiento_id', $value);
    }

    public function scopeZone($query, $value)
    {
        if (!is_null($value))
            $query->where('zone_id', $value);
    }
}
