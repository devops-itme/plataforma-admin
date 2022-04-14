<?php

namespace App\Modules\DepartmentBranchModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentBranch extends Model
{
    use SoftDeletes;
    protected $table = 'department_branches';
    protected $fillable = [
        'department_id',
        'branch_office_id'
    ];

    public function getDepartment()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function getBranchOffice()
    {
        return $this->belongsTo(BranchOffice::class, 'branch_office_id');
    }
}
