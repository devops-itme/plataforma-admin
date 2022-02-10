<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Messenger extends Model
{
    use SoftDeletes;

    protected $table = 'messengers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'vehicle_plate',
        'admission_date',
        'birth_date',
        'production_percentage',
        'contract',
        'exclusive',
        'contract_type_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getContractType()
    {
        return $this->belongsTo(ParameterValue::class, 'contract_type_id');
    }


    //Scopes
    public function scopeName($query, $value)
    {
        if (!is_null($value)) {
            return $query->whereHas('user', function ($q) use ($value) {
                $q->where(DB::raw('concat(name," ",last_name)'), 'like', '%' . $value . '%');
            });
        }
    }
    public function scopeDocument($query, $value)
    {
        if (!is_null($value)) {
            return $query->whereHas('user', function ($q) use ($value) {
                $q->where('document_number', 'like', '%' . $value . '%');
            });
        }
    }
    public function scopeEmail($query, $value)
    {
        if (!is_null($value)) {
            return $query->whereHas('user', function ($q) use ($value) {
                $q->where('email', 'like', '%' . $value . '%');
            });
        }
    }
    public function scopePhone($query, $value)
    {
        if (!is_null($value)) {
            return $query->whereHas('user', function ($q) use ($value) {
                $q->where('phone', 'like', '%' . $value . '%');
            });
        }
    }
    public function scopePlate($query, $value)
    {
        if (!is_null($value))
            $query->where('vehicle_plate', 'like', '%'.$value.'%');
    }
    public function scopeState($query, $value)
    {
        if (!is_null($value)){
            return $query->whereHas('user', function ($q) use ($value) {
                $q->where('state',$value);
            });
        }
    }
}
