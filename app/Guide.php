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
        'state'
    ];

    public function getOrder()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
