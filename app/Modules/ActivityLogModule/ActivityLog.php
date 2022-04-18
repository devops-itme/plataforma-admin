<?php

namespace App\Modules\ActivityLogModule;

use App\Modules\UserModule\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    // use SoftDeletes;
    protected $table = 'activity_log';
    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties'
    ];

    public function getCauser()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }

    public function storeLog($log_name = null, $description = null, $subject_type = null, $subject_id = null, $causer_type = null, $causer_id = null, $properties = null )
    {
        try {
            $data = [
                'log_name' => $log_name,
                'description' => $description,
                'subject_type' => $subject_type,
                'subject_id' => $subject_id,
                'causer_type' => $causer_type,
                'causer_id' => $causer_id,
                'properties' => $properties
            ];
            $this->create($data);
            return json_encode([
                'state' => 200,
                'data' => $data,
                'error' => '',
                'message' => 'Log creado'
            ]);
        } catch (\Throwable $th) {
            return json_encode([
                'state' => 500,
                'data' => '',
                'error' => $th->getMessage(),
                'message' => 'Error inesperado'
            ]);
        }
    }
}
