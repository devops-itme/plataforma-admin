<?php

namespace App\Modules\ActivityLogModule\Controllers;

use App\Modules\ActivityLogModule\ActivityLog;
use App\Http\Controllers\Controller;
use App\Modules\RoleModule\Role;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    protected $path = 'ActivityLogModule.views.html.';

    public function index(Activity $model)
    {

        $event = request()->event;
        $causerName = request()->causerName;
        $causerLastName = request()->causerLastName;
        $action = request()->action;
        $role = request()->role;
        $initDate = request()->initDate;
        $finDate = request()->finDate;

        $model = $model->orderByDesc('created_at');

        if (!is_null($event)) {
            $model->where('log_name', 'like', "%$event%");
        }
        if (!is_null($causerName)) {
            $model->whereHasMorph('causer', '*', function ($q) use ($causerName) {
                $q->where("name", 'like', $causerName);
            });
        }
        if (!is_null($causerLastName)) {
            $model->whereHasMorph('causer', '*', function ($q) use ($causerLastName) {
                $q->where("last_name", 'like', $causerLastName);
            });
        }
        if (!is_null($action)) $model->where('description', 'like', "%$action%");
        if (!is_null($role)) {
            $model->whereHasMorph('causer', '*', function ($q) use ($role) {
                $q->where('role_id', $role);
            });
        }
        if (!is_null($initDate) || !is_null($finDate)) {
            if (!is_null($initDate)) {
                $model->whereDate('created_at', '>=', $initDate);
            }
            if (!is_null($finDate)) {
                $model->whereDate('created_at', '<=', $finDate);
            }
        }

        $roles = Role::where('state', 1)->get();

        return view($this->path . 'logs', ['users' => $model->paginate(15), 'roles' => $roles]);
        $logs = ActivityLog::get();
        return view($this->path . 'logs', compact('logs'));
    }
}
