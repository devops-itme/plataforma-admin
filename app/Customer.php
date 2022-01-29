<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'user_id',
        'birthday',
        'zone_id',
        'contact',
        'payment_period',
        'credit',
        'taxes',
        'receive_emails',
        'fullfill',
        'handling',
        'COD_value',
        'business_name',
        'tradename',
        'state'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getZone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }
}
