<?php

namespace App\Modules\GuidanceDocumentModule\Controllers;

use App\Modules\GuidanceDocumentModule\GuidanceDocument;
use Illuminate\Support\Facades\Validator;
use App\Modules\GuideModule\Controllers\GuideTrait;
use Illuminate\Validation\Rule;

trait GuidanceDocsTrait
{
    use GuideTrait;

    public function GuidanceDocsValidate($request, $action = null)
    {
        return Validator::make(
            $request->all(),
            [
                'guide_id' => 'required|exists:guides,id',
                'url_document' => [
                    Rule::requiredIf($action == 'create'), 'string'
                ],
                'type' => 'nullable|numeric|exists:parameter_values,id'
            ]
        );
    }

    public function storeGuidanceDoc($request)
    {
        $validator = $this->GuidanceDocsValidate($request, 'create');
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error' , $validator->errors()->first());
        }
        try {

            $guidance_doc = GuidanceDocument::create([
                'guides_id' => $request->guide_id,
                'url_document' =>$request->url_document,
                'type' =>$request->type,
            ]);
            return $this->respond(200, $guidance_doc, null, 'Documento creado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al crear el documento');
        }
    }

    public function updateGuidanceDoc($request)
    {
        $validator = $this->GuideValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $guidance_doc = GuidanceDocument::findOrFail($request->guidance_doc_id);
            if (is_null($guidance_doc)) {
                return $this->respond(500, [], 'user not found', 'No se encontró el documento');
            }
            $guidance_doc->update([
                'guides_id' => $request->guide_id,
                'url_document' => $request->url_document,
                'type' =>$request->type,
            ]);
            return $this->respond(200, $guidance_doc, null, 'Documento actualizado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar documento');
        }
    }

    public function deleteGuidanceDoc($id)
    {
        try {
            $guidance_doc = GuidanceDocument::findOrFail($id);
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
