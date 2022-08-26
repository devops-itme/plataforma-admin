<?php

namespace App\Modules\ActivityLogModule\Controllers;

use App\Modules\ActivityLogModule\ActivityLog;
use App\Http\Controllers\Controller;
use App\Modules\RoleModule\Role;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;

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

        $roles = Role::where('state', 1)->get();

        $roles_log = DB::table('activity_log AS al')->select('al.log_name AS evento', 'u.name AS causante_name', 'u.last_name AS causante_last_name', 'r.name AS rol', 'al.description AS descripcion', 'al.created_at AS fecha')
            ->join('users as u', 'u.id', '=', 'al.causer_id')
            ->join('roles as r', 'u.role', '=', 'r.id')
            ->when(!empty($event), function ($query) use ($event) {
                return $query->where('al.log_name', 'like', '%' . $event . '%');
            })
            ->when(!empty($causerName), function ($query) use ($causerName) {
                return $query->where('u.name','like', '%'. $causerName . '%');
            })
            ->when(!empty($causerLastName), function ($query) use ($causerLastName) {
                return $query->where('u.last_name', '%'. $causerLastName . '%');
            })
            ->when(!empty($action), function ($query) use ($action) {
                return $query->where('al.description', 'like', '%' .  request()->action . '%');
            })
            ->when(!empty($role), function ($query) use ($role) {
                return $query->where('r.name', $role);
            })
            ->when(!is_null($initDate) && !is_null($finDate), function ($query) use ($initDate, $finDate) {
                return $query->whereBetween(DB::raw('DATE(al.created_at)'), [$initDate, $finDate]);
            })
            ->orderByDesc('al.created_at')
            ->paginate(15);

        // return view($this->path . 'logs', ['users' => $model->paginate(15), 'roles' => $roles]);
        return view($this->path . 'logs', compact('roles_log', 'roles'));
        $logs = ActivityLog::get();
        return view($this->path . 'logs', compact('logs'));
    }
}
