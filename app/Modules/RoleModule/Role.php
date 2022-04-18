<?php

namespace App\Modules\RoleModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class Role extends Model
{
    use SoftDeletes, LogsActivity;
    protected $fillable = [
        'name',
        'state',
    ];

    /* Logs Config */
    protected static $logFillable = true;
    protected static $submitEmptyLogs = false;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = __($eventName);
        if ($activity->causer) {
            $activity->description = "Se ha " . __($eventName) . " el rol " . $activity->subject->fullName;
        }
    }
    /*End logs config */
}
