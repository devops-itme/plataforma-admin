<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'parent_id',
        'name',
        'last_name',
        'document_type',
        'document_number',
        'email',
        'phone',
        'password',
        'role',
        'state'
    ];
}
