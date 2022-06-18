<?php

namespace App\Modules\GuideLogModule;

use App\Http\Controllers\Traits\RestActions;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\StatusMatrixModule\StatusMatrix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
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

    public function getIssue()
    {
        return $this->belongsTo(ParameterValue::class, 'issue_id');
    }

    public function validateGuideLog($request)
    {
        return Validator::make(
            $request->all(),
            [
                'guide_id' => 'required|numeric|exists:guides,id',
                'user_id' => 'required|numeric|exists:users,id',
                'status_matrix_id' => 'required|numeric|exists:status_matrix,id',
                'issue_id' => 'nullable|numeric|exists:parameter_values,id',
                'sign_customer' => 'nullable|numeric',
                'detail_log' => 'nullable|numeric',
                'url_document' => 'nullable|numeric',
                'active' => 'nullable|numeric',
            ]
        );
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
            $guide_log = $this::where('guide_id', $request->guide_id)->get();
            return $this->respond(200, $guide_log, null, 'Log de guías');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function saveGuideLog($request)
    {
        try {
            $validator = $this->validateGuideLog($request);
            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
            }
            DB::beginTransaction();
            $guide_log = $this::create([
                'guide_id' => $request->guide_id,
                'user_id' => $request->user_id,
                'status_matrix_id' => $request->status_matrix_id,
                'issue_id' => $request->issue_id,
                'sign_customer' => $request->sign_customer,
                'detail_log' => $request->detail_log,
                'url_document' => $request->url_document,
                'active' => $request->active ?? 1,
            ]);
            DB::commit();
            return $this->respond(200, $guide_log, null, 'Log de guía creado exitosamente');
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }
}
