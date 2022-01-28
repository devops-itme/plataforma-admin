<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Messenger extends Model
{
    use SoftDeletes;

    protected $table = 'messengers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'vehicle_plate',
        'admission_date',
        'production_percentage',
        'contract',
        'exclusive'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }



    public function scopeName($query, $value)
    {
        if (!is_null($value))
            return $query->whereHas('user', function ($query) use ($value) {
                $query->where('name', 'like', '%' . $value . '%');
            }
        );
    }
}
