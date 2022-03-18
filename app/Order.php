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
        'schedule_date',
        'schedule_time',
        'schedule_time_range',
        'insured_value',
        'money_to_collect',
        'percentage_to_collect',
        'customer_user_id',
        'creator_user_id',
        'zone',
        'address_id',
        'description',
        'state',
        'service_type',
        'department_id',
        'branch_office',
        'dispatched',
        'app_status',
        'status_matrix_id',
        'additional_address',
        'additional_email',
        'additional_phone'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAddress()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function getStatusMatrix()
    {
        return $this->belongsTo(StatusMatrix::class, 'status_matrix_id');
    }

    public function getGuides()
    {
        return $this->hasMany(Guide::class, 'order_id');
    }

    public function getOrderType()
    {
        return $this->belongsTo(ParameterValue::class, 'order_type');
    }

    public function getOrderState()
    {
        return $this->belongsTo(ParameterValue::class, 'state');
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

    public function getScheduleTime()
    {
        return $this->belongsTo(PickupHour::class, 'schedule_time');
    }

    public function getLog()
    {
        return $this->hasMany(OrderLog::class, 'order_id');
    }


    //SCOPES

    public function scopeNumber($query, $value)
    {
        if (!is_null($value))
            return $query->where('order_number', 'like', '%' . $value . '%');
    }
    public function scopeOrder_type($query, $value)
    {
        if (!is_null($value))
            return $query->where('order_type', $value);
    }
    public function scopeCustomer($query, $value)
    {
        if (!is_null($value)) {
            return $query->whereHas('getUser', function ($q) use ($value) {
                $q->where(DB::raw('concat(name," ",last_name)'), 'like', '%' . $value . '%');
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
        if (!is_null($value)) {
            return $query->where('state', $value);
        }
    }
    public function scopeScope($query, $statusArr)
    {
        if (!is_null($statusArr)) {
            return $query->whereIn('status_matrix_id', $statusArr);
        }
    }

    public function scopeMessengerOrders($query, $messenger_user_id)
    {
        if (!is_null($messenger_user_id)) {
            return $query->whereHas('getGuides', function ($query) use ($messenger_user_id) {
                $query->whereHas('getRoute', function ($query) use ($messenger_user_id) {
                    $query->where('messenger_user_id', $messenger_user_id);
                });
            });
        }
    }
}
