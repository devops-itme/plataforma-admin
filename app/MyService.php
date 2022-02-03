<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyService extends Model
{
    use SoftDeletes;

    protected $table = 'my_services';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'state'
    ];
}
