<?php

namespace App\Modules\GuidanceDocumentModule\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\GuidanceDocumentModule\GuidanceDocument;
use App\Modules\ParameterValueModule\ParameterValue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GuidanceDocumentController extends Controller
{
    use RestActions;

    protected $GuidanceDocument;

    public function __construct()
    {
        $this->GuidanceDocument = new GuidanceDocument();
    }

    public function getDocumentsByGuide(Request $request)
    {
        if ($request->path) {
            return Storage::disk('s3')->exists($request->path);
        }
        $guide_id = $request->guide_id;
        return $this->GuidanceDocument->getDocumentsByGuide($guide_id);
    }

    public function store(Request $request)
    {
        try {
            if (!is_numeric($request->type)) {
                $type = ParameterValue::where('name', $request->type)->whereHas('getParameter', function ($query) {
                    $query->where('name', 'guide_document_type');
                })->first();
                if (is_null($type)) {
                    return $this->respond(500, $request->all(), 'type not found', 'Tipo de documento no encontrado');
                }
                $request->merge(['type' => $type->id]);
            }

            $document = $request->document;
            if (!is_array($document)) {
                $document = [$document];
            }

            DB::beginTransaction();
            foreach ($document as $file) {
                if (!is_file($file)) {
                    return $this->respond(500, $request->all(), 'is not file', 'Debe subir un archivo');
                }
                
                $path = Storage::disk('s3')->put('/guidance_doc', $file, 'public');
                $request->merge(['url_document' => $path]);

                $response = $this->GuidanceDocument->saveGuidanceDoc($request);
                if ($response['state'] != 200) {
                    DB::rollBack();
                    return $response;
                }
            }

            DB::commit();

            return $this->respond(200, $path, '', 'Documento almacenado de forma exitosa.');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage() . ' Line: ' . $e->getLine(), 'Error del servidor');
        }
    }
}
