<?php

namespace App\Modules\RouteModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Route extends Model
{
    use SoftDeletes;

    protected $table = 'routes';
    protected $fillable = [
        'guide_id',
        'messenger_user_id',
        'date'
    ];

    public function getGuide()
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }

    public function getMessenger()
    {
        return $this->belongsTo(User::class, 'messenger_user_id');
    }
}
