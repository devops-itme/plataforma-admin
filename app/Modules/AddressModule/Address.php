<?php

namespace App\Modules\AddressModule;

use App\Http\Controllers\Traits\RestActions;
use App\Modules\UserModule\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class Address extends Model
{
    use SoftDeletes, LogsActivity, RestActions;

    protected $table = 'addresses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'name',
        'lat',
        'lng',
        'description',
        'state'
    ];

    /* Logs Config */
    protected static $logFillable = true;
    protected static $submitEmptyLogs = false;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = __($eventName);
        if ($activity->causer) {
            $activity->description = "Se ha " . __($eventName) . " la dirección " . $activity->subject->fullName;
        }
    }
    /*End logs config */

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function showAddress($id)
    {
        try {
            $address = $this::find($id);
            if (is_null($address)) {
                return $this->respond(500, null, 'address not found', 'No se encontró la dirección');
            }
            return $this->respond(200, $address, null, 'Dirección encontrada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al buscar la dirección');
        }
    }
}
