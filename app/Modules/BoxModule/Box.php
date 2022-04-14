<?php

namespace App\Modules\BoxModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Box extends Model
{
    use SoftDeletes;
    protected $table = 'boxes';
    protected $fillable = [
        'guide_id',
        'weight',
        'long',
        'broad',
        'high',
        'vol_weight',
        'description',
        'state'
    ];

    public function getGuide()
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }
}
