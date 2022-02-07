<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable, HasApiTokens, SoftDeletes;

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

    public function getCustomer()
    {
        return $this->hasOne(Customer::class);
    }

    public function getMessenger()
    {
        return $this->hasOne(Messenger::class);
    }

    public function getDocumentType()
    {
        return $this->belongsTo(ParameterValue::class, 'document_type');
    }

    public function getParent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    //BRANCH OFFICE
    public function getBranchOffice()
    {
        return $this->hasMany(BranchOffice::class, 'user_id');
    }



}
