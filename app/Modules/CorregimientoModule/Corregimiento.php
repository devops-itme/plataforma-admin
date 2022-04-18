<?php

namespace App\Modules\CorregimientoModule;

use App\Modules\DistrictModule\District;
use App\Modules\NeighborhoodModule\Neighborhood;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Corregimiento extends Model
{
    use SoftDeletes;

    protected $table = 'corregimientos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'district_id',
        'name',
        'state'
    ];

    public function getDistrict()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function getNeighborhoods()
    {
        return $this->hasMany(Neighborhood::class, 'corregimiento_id');
    } 

    public function scopeDistrict($query, $value)
    {
        if (!is_null($value))
            $query->where('district_id', $value);
    }
}
