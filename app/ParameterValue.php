<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParameterValue extends Model
{
    protected $table = 'parameter_values';

    protected $fillable = [
        'parameter_id',
        'name',
        'description',
        'state'
    ];

    public function getParameter()
    {
        return $this->belongsTo(Parameter::class, 'parameter_id');
    }
}
