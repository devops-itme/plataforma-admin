<?php

namespace App\Modules\GuideLogModule;

use App\Modules\StatusMatrixModule\StatusMatrix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuideLog extends Model
{
    use SoftDeletes;
    protected $table = 'guide_logs';
    protected $fillable = [
        'guide_id',
        'user_id',
        'status_matrix_id',
        'issue_id',
        'sign_customer',
        'detail_log',
        'url_document',
        'active',
    ];

    public function getState()
    {
        return $this->belongsTo(StatusMatrix::class, 'status_matrix_id');
    }
}
