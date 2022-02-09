<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
