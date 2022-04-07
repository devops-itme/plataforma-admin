<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use SoftDeletes;

    protected $table = 'provinces';
    protected $primaryKey = 'id';
    protected $fillable = [
        'country_id',
        'name',
        'state'
    ];

    public function getCountry()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function getDistricts()
    {
        return $this->hasMany(District::class, 'province_id');
    }

    public function scopeCountry($query, $value)
    {
        if (!is_null($value))
            $query->where('country_id', $value);
    }
}
