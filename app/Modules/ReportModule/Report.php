<?php

namespace App\Modules\ReportModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    protected $table = 'reports';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id',
        'state'
    ];

}
