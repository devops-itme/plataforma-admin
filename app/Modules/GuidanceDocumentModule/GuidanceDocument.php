<?php

namespace App\Modules\GuidanceDocumentModule;

use App\Http\Controllers\Traits\RestActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GuidanceDocument extends Model
{
    use SoftDeletes, RestActions;

    protected $table = 'guidance_documents';
    protected $fillable = [
        'guide_id',
        'url_document',
        'type'
    ];
    
    protected $appends = ['file_url'];

    public function getFileUrlAttribute()
    {
        $link = "";
        if(!empty($this->url_document)){
            $link = Storage::disk('s3')->url($this->url_document);
        }
        return $link;
    }

    public function getGuide()
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }

    public function scopeWhereGuide($query, $value)
    {
        if (!is_null($value))
            return $query->where('guide_id', $value);
    }

    public function getDocumentsByGuide($guide_id)
    {
        try {
            $guidance_docs = $this::whereGuide($guide_id)->get();
            return $this->respond(200, $guidance_docs, null, 'Documentos de la guía n° ' . $guide_id);
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al encontrar los documentos');
        }
    }

    public function GuidanceDocsValidate($request, $action = null)
    {
        return Validator::make(
            $request->all(),
            [
                'guide_id' => 'nullable|exists:guides,id',
                'url_document' => [
                    Rule::requiredIf($action == 'create'), 'string'
                ],
                'type' => 'nullable|numeric|exists:parameter_values,id'
            ]
        );
    }

    public function saveGuidanceDoc($request)
    {
        $validator = $this->GuidanceDocsValidate($request, 'create');
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {

            $guidance_doc = $this::create([
                'guide_id' => $request->guide_id,
                'url_document' => $request->url_document,
                'type' => $request->type,
            ]);
            return $this->respond(200, $guidance_doc, null, 'Documento creado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al crear el documento');
        }
    }

    public function updateGuidanceDoc($request)
    {
        $validator = $this->GuidanceDocsValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $guidance_doc = $this::findOrFail($request->guidance_doc_id);
            if (is_null($guidance_doc)) {
                return $this->respond(500, [], 'user not found', 'No se encontró el documento');
            }
            $guidance_doc->update([
                'guide_id' => $request->guide_id,
                'url_document' => $request->url_document,
                'type' => $request->type,
            ]);
            return $this->respond(200, $guidance_doc, null, 'Documento actualizado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar documento');
        }
    }

    public function deleteGuidanceDoc($id)
    {
        try {
            $guidance_doc = $this::findOrFail($id);
            if (is_null($guidance_doc)) {
                return $this->respond(500, [], 'user not found', 'No se encontró el documento');
            }
            $guidance_doc->delete();
            return $this->respond(200, $guidance_doc, null, 'Documento eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar documento');
        }
    }
}
