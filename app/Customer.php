<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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

    //Scopes
    public function scopeName($query, $value)
    {
        if (!is_null($value)) {
            return $query->whereHas('getUser', function($q) use($value){
                $q->where(DB::raw('concat(name," ",last_name)'), 'like', '%'.$value.'%');
            });
        }
    }
    public function scopeDocument($query, $value)
    {
        if (!is_null($value)) {
            return $query->whereHas('getUser', function($q) use($value){
                $q->where('document_number', 'like', '%'.$value.'%');
            });
        }
    }
    public function scopeEmail($query, $value)
    {
        if (!is_null($value)) {
            return $query->whereHas('getUser', function($q) use($value){
                $q->where('email', 'like', '%'.$value.'%');
            });
        }
    }
    public function scopePhone($query, $value)
    {
        if (!is_null($value)) {
            return $query->whereHas('getUser', function($q) use($value){
                $q->where('phone', 'like', '%'.$value.'%');
            });
        }
    }
    public function scopeZone($query, $value)
    {
        if (!is_null($value))
            return $query->where('zone_id', $value);
    }
    public function scopeState($query, $value)
    {
        if (!is_null($value))
            return $query->where('state', $value);
    }
}
