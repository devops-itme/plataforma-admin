<?php

namespace App\Modules\PermissionModule;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
        'actions'
    ];
}
