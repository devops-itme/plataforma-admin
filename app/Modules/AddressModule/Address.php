<?php

namespace App\Modules\AddressModule;

use App\Modules\UserModule\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $table = 'addresses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'name',
        'lat',
        'lng',
        'description',
        'state'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
