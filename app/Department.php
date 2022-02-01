<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];

    public function bankUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
