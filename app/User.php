<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
    public function getAddresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    //BRANCH OFFICE
    public function getBranchOffice()
    {
        return $this->hasMany(BranchOffice::class, 'user_id');
    }

    //Scopes
    public function scopeName($query, $value)
    {
        if (!is_null($value))
            $query->where(DB::raw('concat(name," ",last_name)'), 'like', '%'.$value.'%');
    }
    public function scopeDocument($query, $value)
    {
        if (!is_null($value))
        $query->where('document_number', 'like', '%'.$value.'%');
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
    public function scopeState($query, $value)
    {
        if (!is_null($value))
            $query->where('state',$value);
    }

}
