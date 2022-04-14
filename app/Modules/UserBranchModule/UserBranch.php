<?php

namespace App\Modules\UserBranchModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBranch extends Model
{
    use SoftDeletes;
    protected $table = 'user_branches';
    protected $fillable = [
        'user_id',
        'branch_office_id'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getBranchOffice()
    {
        return $this->belongsTo(BranchOffice::class, 'branch_office_id');
    }
}
