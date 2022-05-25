<?php

namespace App\Modules\ParametersModule;

use App\Http\Controllers\Traits\RestActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parameter extends Model
{
    use SoftDeletes, RestActions;
    protected $table = 'parameters';

    protected $fillable = [
        'name',
        'description',
        'editable',
        'state'
    ];

    public function getParameterValue()
    {
        return $this->hasMany(ParameterValue::class, 'parameter_id');
    }

    public function scopeEditable($query)
    {
        $query->where('editable', 1);
    }

    public function scopeNotEditable($query)
    {
        $query->where('editable', 0);
    }

    public function getEditableParameters()
    {
        try {
            $editable_parameters = $this::editable()->get();
            return $this->respond(500, $editable_parameters, null, 'Parámetros editables');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error de servidor');
        }
    }
}
