<?php

namespace App\Modules\PermissionModule;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class Permission extends Model
{
    use LogsActivity;
    protected $table = 'permissions';

    protected $fillable = [
      'role_id','module_id', 'actions','state'
    ];

     /* Logs Config */
     protected static $logFillable = true;
     protected static $submitEmptyLogs = false;
 
     public function tapActivity(Activity $activity, string $eventName)
     {
         $activity->log_name = __($eventName);
         if ($activity->causer) {
             $activity->description = "Se ha " . __($eventName) . " el permiso " . $activity->subject->fullName;
         }
     }
     /*End logs config */
 
}
