<?php

namespace App\Modules\AddressModule;

use App\Modules\UserModule\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class Address extends Model
{
    use SoftDeletes, LogsActivity;

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
}
