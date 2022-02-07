<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchOffice extends Model
{
    protected $table = 'branch_offices';
    protected $fillable = [
        'name',
        'description',
        'type',
        'zone_id',
        'address',
        'email',
        'contact',
        'document_type',
        'document_number',
        'lat',
        'lng',
        'default',
        'payment_method',
        'phone',
        'usage_mode',
        'user_id'
    ];


    //Bank departments
    public function getDepartments()
    {
        return $this->hasMany(Department::class, 'branch_office_id');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function boot()
    {
        parent::boot();
        //DELETE CASCADE DEPARTMENTS
        static::deleting(function ($deparments) {
            $deparments->getDepartments()->delete();
        });
    }
}
