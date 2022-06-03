<?php

namespace App\Modules\GuidanceDocumentModule\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\GuidanceDocumentModule\GuidanceDocument;
use App\Modules\ParameterValueModule\ParameterValue;
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
        $guide_id = $request->guide_id;
        return $this->GuidanceDocument->getDocumentsByGuide($guide_id);
    }

    public function store(Request $request)
    {
        try {
            $validator =  Validator::make(
                $request->all(),
                ['document' => ['required', $request->base64 == 1 ? 'string' : 'file'],]
            );
            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
            }
            DB::beginTransaction();

            if (!is_numeric($request->type)) {
                $type = ParameterValue::where('name', $request->type)->whereHas('getParameter', function ($query) {
                    $query->where('name', 'guide_document_type');
                })->first();
                if (is_null($type)) {
                    return $this->respond(500, $request->all(), 'type not found', 'Tipo de documento no encontrado');
                }
                $request->merge(['type' => $type->id]);
            }
            $file = null;
            if (File($request->base64 == 1)) {
                $img = str_replace(' ', '+', $request->document);
                $file = base64_decode($img);
            } else {
                $file = $request->file('document');
            }
            $path = Storage::disk('s3')->put('/guidance_doc', $file, 'public');
            $request->merge(['url_document' => $path]);

            $store_doc = $this->GuidanceDocument->saveGuidanceDoc($request);
            if ($store_doc['state'] != 200) {
                DB::rollBack();
                return $store_doc;
            }

            DB::commit();

            return $this->respond(200, [], '', 'Documento almacenado de forma exitosa.');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage() . ' Line: ' . $e->getLine(), 'Error del servidor');
        }
    }
}
