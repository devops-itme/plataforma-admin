<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderLog extends Model
{
    use SoftDeletes;
    protected $table = 'orders_log';
    protected $fillable = [
        'state',
        'datetime',
        'url_document',
        'user_id',
        'order_id'
    ];

    public function getState()
    {
        return $this->belongsTo(StatusMatrix::class, 'state');
    }
}
