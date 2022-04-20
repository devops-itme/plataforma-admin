<?php

namespace App\Modules\ParameterValueModule;

use App\Modules\ParametersModule\Parameter;
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
        'state',
        'editable'
    ];

    public function getParameter()
    {
        return $this->belongsTo(Parameter::class, 'parameter_id');
    }
}
