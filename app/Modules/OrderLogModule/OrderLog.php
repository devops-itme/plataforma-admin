<?php

namespace App\Modules\OrderLogModule;

use App\Modules\StatusMatrixModule\StatusMatrix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderLog extends Model
{
    use SoftDeletes;
    protected $table = 'order_logs';
    protected $fillable = [
        'order_id',
        'user_id',
        'status_matrix_id',
        'url_document',
        'active',
    ];

    public function getState()
    {
        return $this->belongsTo(StatusMatrix::class, 'status_matrix_id');
    }
}
