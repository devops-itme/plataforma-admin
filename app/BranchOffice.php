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
}
