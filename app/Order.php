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
        'number',
        'user_id',
        'service_type_id',
        'vehicle_type_id',
        'payment_method_id',
        'schedule_date',
        'schedule_time',
        'express_delivery',
        'last_destination_return',
        'insured_value',
        'percentage_receivable',
        'value_receivable',
        'state'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getGuides()
    {
        return $this->hasMany(Guide::class, 'order_id');
    }
    //SCOPES

    public function scopeNumber($query, $value)
    {
        if (!is_null($value))
            return $query->where('number', 'like', '%'.$value.'%');
    }
    public function scopeService_type($query, $value)
    {
        if (!is_null($value))
            return $query->where('service_type_id', $value);
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
}
