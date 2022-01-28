<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $table = 'parameters';

    protected $fillable = [
        'name',
        'description',
        'state'
    ];
}
