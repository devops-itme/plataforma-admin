<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $table = 'departments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'state',
    ];

    public function getBranchOffice()
    {
        return $this->belongsTo(BranchOffice::class, 'branch_office_id');
    }


}
