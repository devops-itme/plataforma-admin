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

            if ($request->base64 == 1) {
                $img = str_replace('data:image/png;base64,', '', $request->document);
                $img = str_replace(' ', '+', $img);
                $file = base64_decode($img);
                // $imageName = Carbon::now()->toDateString() . '.' . $request->file_type;
                $imageName = Carbon::now() . '.jpg';
                Storage::disk('local')->put('/guidance_doc' . $imageName, $file, 'public');
                $image_url = Storage::disk('local')->url($imageName);
                return $this->respond(500, $image_url , '', 'Documento almacenado de forma exitosa.');
                $path = 'guidance_doc/' . $imageName;
            } else {
                $file = $request->file('document');
                $path = Storage::disk('local')->put('/guidance_doc', $file, 'public');
            }
            $request->merge(['url_document' => $path]);

            $store_doc = $this->GuidanceDocument->saveGuidanceDoc($request);
            if ($store_doc['state'] != 200) {
                DB::rollBack();
                return $store_doc;
            }

            DB::commit();

            return $this->respond(200, $path, '', 'Documento almacenado de forma exitosa.');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage() . ' Line: ' . $e->getLine(), 'Error del servidor');
        }
    }
}
