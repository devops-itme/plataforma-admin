<?php

namespace App\Modules\ServiceTypeModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceType extends Model
{
    use SoftDeletes;

    protected $table = 'service_types';
    protected $primaryKey = 'id';
    protected $fillable = [
        'rate_id',
        'name',
        'description',
        'state'
    ];

}
