<?php

namespace App\Modules\GuidanceDocumentModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuidanceDocument extends Model
{
    use SoftDeletes;
    protected $table = 'guidance_documents';
    protected $fillable = [
        'guides_id ',
        'url_document'
    ];

    public function getGuide()
    {
        return $this->belongsTo(Guide::class, 'guides_id');
    }
}
