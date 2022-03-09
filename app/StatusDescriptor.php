<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusDescriptor extends Model
{
    protected $table = 'status_descriptors';
    protected $fillable = [
        'description',
        'role_id',
        'status_matrix_is',
    ];

}
