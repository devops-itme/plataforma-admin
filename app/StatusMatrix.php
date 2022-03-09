<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusMatrix extends Model
{
    protected $table = 'status_matrix';
    protected $fillable = [
        'name',
        'scope_id',
        'issue_id',
    ];
}
