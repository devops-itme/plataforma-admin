<?php

namespace App\Modules\StatusMatrixModule;

use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\StatusDescriptorModule\StatusDescriptor;
use Illuminate\Database\Eloquent\Model;

class StatusMatrix extends Model
{
    protected $table = 'status_matrix';
    protected $fillable = [
        'name',
        'scope_id',
        'issues',
    ];


    public function getDescriptor()
    {
        return $this->hasMany(StatusDescriptor::class, 'status_matrix_id');
    }

    public function getScope()
    {
        return $this->belongsTo(ParameterValue::class, 'scope_id');
    }


    public function scopeScope($query, $value)
    {
        if (!is_null($value))
            $query->where('scope_id', $value);
    }
}
