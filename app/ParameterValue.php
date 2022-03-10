<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParameterValue extends Model
{
    use SoftDeletes;
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
