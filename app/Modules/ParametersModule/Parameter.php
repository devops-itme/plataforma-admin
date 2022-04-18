<?php

namespace App\Modules\ParametersModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parameter extends Model
{
    use SoftDeletes;
    protected $table = 'parameters';

    protected $fillable = [
        'name',
        'description',
        'state'
    ];

    public function getParameterValue()
    {
        return $this->hasMany(ParameterValue::class, 'parameter_id');
    }
}
