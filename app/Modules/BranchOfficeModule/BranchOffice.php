<?php

namespace App\Modules\BranchOfficeModule;

use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\UserModule\User;
use App\Modules\DepartmentBranchModule\DepartmentBranch;
use App\Modules\ZoneModule\Zone;
use App\Modules\UserBranchModule\UserBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class BranchOffice extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'branch_offices';
    protected $fillable = [
        'name',
        'description',
        'type',
        'zone_id',
        'address',
        'email',
        'contact',
        'document_type',
        'document_number',
        'lat',
        'lng',
        'default',
        'payment_method',
        'phone',
        'plan',
        'usage_mode',
        'user_id',
        'state'
    ];

    /* Logs Config */
    protected static $logFillable = true;
    protected static $submitEmptyLogs = false;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = __($eventName);
        if ($activity->causer) {
            $activity->description = "Se ha " . __($eventName) . " la sucursal " . $activity->subject->fullName;
        }
    }
    /*End logs config */

    //Bank departments
    public function getDepartment()
    {
        return $this->hasOne(DepartmentBranch::class, 'branch_office_id');
    }

    public function getBranchUser()
    {
        return $this->hasMany(UserBranch::class, 'branch_office_id');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getType()
    {
        return $this->belongsTo(ParameterValue::class, 'type');
    }

    public function getZone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    // protected static function boot()
    // {
    //     parent::boot();
    //     //DELETE CASCADE DEPARTMENTS
    //     static::deleting(function ($deparments) {
    //         $deparments->getDepartments()->delete();
    //     });
    // }

    //SCOPES
    public function scopeName($query, $value)
    {
        if (!is_null($value))
            $query->where('name', 'like', '%'.$value.'%');
    }
    public function scopeDescription($query, $value)
    {
        if (!is_null($value))
            $query->where('description', 'like', '%'.$value.'%');
    }
    public function scopeAddress($query, $value)
    {
        if (!is_null($value))
            $query->where('address', 'like', '%'.$value.'%');
    }
    public function scopeEmail($query, $value)
    {
        if (!is_null($value))
            $query->where('email', 'like', '%'.$value.'%');
    }
    public function scopePhone($query, $value)
    {
        if (!is_null($value))
            $query->where('phone', 'like', '%'.$value.'%');
    }
    public function scopeDefault($query, $value)
    {
        if (!is_null($value))
            $query->where('default', $value);
    }
}
