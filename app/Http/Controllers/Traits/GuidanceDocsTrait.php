<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\RestActions;
use App\GuidanceDocument;

trait GuidanceDocsTrait
{
    use RestActions;

    public function GuidanceDocsValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'guides_id ' => 'required|exists:guides,id',
                'url_document ' => 'nullable|string'
            ]
        );
    }

    public function storeGuidanceDoc($request)
    {
        $validator = $this->GuidanceDocsValidate($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error' . $validator->errors()->first());
        }
        try {
            $guidance_doc = GuidanceDocument::create([
                'guides_id' => $request->guides_id,
                'url_document' =>$request->url_document
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
            $guidance_doc = GuidanceDocument::find($request->guidance_doc_id);
            if (is_null($guidance_doc)) {
                return $this->respond(500, [], 'user not found', 'No se encontro el documento');
            }
            $guidance_doc->update([
                'guides_id' => $request->guides_id,
                'url_document' => $request->url_document
            ]);
            return $this->respond(200, $guidance_doc, null, 'Documento actualizado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar documento');
        }
    }

    public function deleteGuide($id)
    {
        try {
            $guidance_doc = GuidanceDocument::find($id);
            if (is_null($guidance_doc)) {
                return $this->respond(500, [], 'user not found', 'No se encontro el documento');
            }
            $guidance_doc->delete();
            return $this->respond(200, $guidance_doc, null, 'Documento eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar documento');
        }
    }
}
