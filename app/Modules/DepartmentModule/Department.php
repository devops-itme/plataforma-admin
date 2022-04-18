<?php

namespace App\Modules\DepartmentModule;

use App\Modules\BranchOfficeModule\BranchOffice;
use App\Modules\UserDepartmentModule\UserDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $table = 'departments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'branch_office_id',
        'name',
        'description',
        'state',
    ];

    public function getBranchOffice()
    {
        return $this->belongsTo(BranchOffice::class, 'branch_office_id');
    }

    public function getDepartmentUser()
    {
        return $this->hasMany(UserDepartment::class, 'department_id');
    }

    //SCOPES
    public function scopeName($query, $value)
    {
        if (!is_null($value))
            $query->where('name', 'like', '%'.$value.'%');
    }
    public function scopeDescription($query, $value)
    {
        if (!is_null($value))
            $query->where('name', 'like', '%'.$value.'%');
    }
    public function scopeNameOffice($query, $value)
    {
        if (!is_null($value)) {
            return $query->whereHas('user', function ($q) use ($value) {
                $q->where('name', 'like', '%' . $value . '%');
            });
        }
    }
    public function scopeState($query, $value)
    {
        if (!is_null($value))
            $query->where('state',$value);
    }

}
