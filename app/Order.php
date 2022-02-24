<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use SoftDeletes;
    protected $table = 'orders';
    protected $fillable = [
        'order_number',
        'user_id',
        'order_type',
        'document_type',
        'order_value',
        'receive_by_COD',
        'internal_product',
        'expenses',
        'diligence_expenses',
        'tax_total',
        'payment_method',
        'urgent_dispatch',
        'return_last_destination',
        'schedule_date',
        'schedule_time',
        'insured_value',
        'money_to_collect',
        'percentage_to_collect',
        'customer_user_id',
        'creator_user_id',
        'zone',
        'state',
        'service_type',
        'department_id',
        'branch_office'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getGuides()
    {
        return $this->hasMany(Guide::class, 'order_id');
    }

    public function getOrderType()
    {
        return $this->belongsTo(ParameterValue::class, 'order_type');
    }

    public function getDocumentType()
    {
        return $this->belongsTo(ParameterValue::class, 'document_type');
    }

    public function getPaymentMethod()
    {
        return $this->belongsTo(ParameterValue::class, 'payment_method');
    }

    public function getState()
    {
        return $this->belongsTo(ParameterValue::class, 'state');
    }

    public function getDepartment()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function getBranchOffice()
    {
        return $this->belongsTo(BranchOffice::class, 'branch_office');
    }


    //SCOPES

    public function scopeNumber($query, $value)
    {
        if (!is_null($value))
            return $query->where('order_number', 'like', '%'.$value.'%');
    }
    public function scopeOrder_type($query, $value)
    {
        if (!is_null($value))
            return $query->where('order_type', $value);
    }
    public function scopeCustomer($query, $value)
    {
        if (!is_null($value)) {
            return $query->whereHas('getUser', function($q) use($value){
                $q->where(DB::raw('concat(name," ",last_name)'), 'like', '%'.$value.'%');
            });
        }
    }
    public function scopeDate($query, $from, $to)
    {
        if (!is_null($from) && !is_null($to)) {
            return $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }
    }
    public function scopeState($query, $value)
    {
        if(!is_null($value)){
            return $query->where('state', $value);
        }
    }
}
