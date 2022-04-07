<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;

    protected $table = 'districts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'province_id',
        'name',
        'state'
    ];

    public function getProvince()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function getCorregimientos()
    {
        return $this->hasMany(District::class, 'district_id');
    } 

    public function scopeProvince($query, $value)
    {
        if (!is_null($value))
            $query->where('province_id', $value);
    }
}
