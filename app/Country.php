<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $table = 'countries';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'state'
    ];

    public function getProvinces()
    {
        return $this->hasMany(Province::class, 'country_id');
    }
}
