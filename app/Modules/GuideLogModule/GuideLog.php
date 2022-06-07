<?php

namespace App\Modules\GuideLogModule;

use App\Http\Controllers\Traits\RestActions;
use App\Modules\StatusMatrixModule\StatusMatrix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class GuideLog extends Model
{
    use SoftDeletes, RestActions;
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

    public function getGuideLogs($request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'guide_id' => 'required|numeric|exists:guides,id'
                ]
            );
            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
            }
            $order_log = $this::where('guide_id', $request->guide_id)->get();
            return $this->respond(200, $order_log, null, 'Log de guías');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }
}
