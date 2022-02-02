<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guide extends Model
{
    use SoftDeletes;

    protected $table = 'guides';
    protected $fillable = [
        'order_id',
        'address_id',
        'delivery_date',
        'shipping_cost'
    ];

    public function FunctionName()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
