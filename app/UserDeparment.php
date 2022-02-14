<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDeparment extends Model
{
    use SoftDeletes;
    protected $table = 'user_deparments';
    protected $fillable = [
        'department_id',
        'user_id'
    ];

    public function getDepartment()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
