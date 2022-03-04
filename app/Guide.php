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
        'branch_office',
        'transport_type',
        'dispatched',
        'address_name',
        'address_lat',
        'address_lng',
        'address_description',
        'zone',
        'concept',
        'rate',
        'value',
        'corp_value',
        'document_type_customes',
        'contact',
        'phone_contact',
        'email_contact',
        'invoice_contact',
        'same_day_delivery',
        'sign',
        'take_photo',
        'packaging',
        'customer_address',
        'state'
    ];

    public function getOrder()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function getRoute()
    {
        return $this->hasOne(Route::class, 'guide_id');
    }

    public function getAddress()
    {
        return $this->belongsTo(Address::class, 'customer_address');
    }

    public function getTransportType()
    {
        return $this->belongsTo(ParameterValue::class, 'transport_type');
    }

    public function getState()
    {
        return $this->belongsTo(ParameterValue::class, 'state');
    }
}
