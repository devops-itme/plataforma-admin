<?php

namespace App\Modules\GuideModule\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuideResource;
use App\Modules\GuidanceDocumentModule\Controllers\GuidanceDocsTrait;
use App\Modules\GuideModule\Controllers\GuideTrait;
use App\Modules\GuideModule\Guide;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\StatusMatrixModule\StatusMatrix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GuideController extends Controller
{
    use GuideTrait, GuidanceDocsTrait;

    public function respond($state, $data = [], $error = null, $message = '')
    {
        return [
            'state' => $state, //response status
            'data' => $data, //response data
            'error' => $error, //bug for developer
            'message' => $message //user message
        ];
    }

    protected $messengerRelationships = [
        'getRoute', 'getRoute.getMessenger', 'getRoute.getMessenger.getMessenger', 'getTransportType'
    ];

    public function index(Request $request)
    {
        $status_matrix = $request->status_matrix ?? [];

        try {
            $status_matrix = StatusMatrix::whereIn('name', $status_matrix)->get(['id']);

            count($status_matrix) == 0 && $status_matrix = null;

            $guides = Guide::where('order_id', $request->order_id)
                ->whereStatusMatrix($status_matrix)
                ->with($this->messengerRelationships)->get();
            $guides = GuideResource::collection($guides);
            return $this->respond(200, $guides, null, 'Guías asignadas');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function updateAdditionalInformation(Request $request)
    {
        $response = $this->setAdditionalInformation($request);
        return $response;
    }

    public function markAsRead(Request $request)
    {
        try {
            $guide = Guide::where('id', $request->guide_id)->first();

            if (is_null($guide)) {
                return $this->respond(500, null, 'not found', 'No se encontró la guiá');
            }
            $updates = ['app_status' => 1];
            if ($guide->update($updates)) {
                return $this->respond(200, $guide, null, 'Guía marcada como leída');
            }
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $guide = Guide::where('id', $request->guide_id)
                ->with($this->messengerRelationships)->first();
            if (is_null($guide)) {
                return $this->respond(500, null, 'not found', 'No se encontró la guía');
            }
            if ($guide->update($request->all())) {
                $guide = GuideResource::collection([$guide]);
                return $this->respond(200, $guide->first(), null, 'Estado de la guía cambiado');
            }
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }

    public function saveEvidence(Request $request)
    {
        try {
            // if (gettype($request->document) == 'array') {
            DB::beginTransaction();
            // foreach ($request->document as $file) {
            if (!is_numeric($request->type)) {
                $type = ParameterValue::where('name', $request->type)->whereHas('getParameter', function ($query) {
                    $query->where('name', 'guide_document_type');
                })->first();
                if (is_null($type)) {
                    $this->respond(200, null, 'type not found', 'Tipo de documento no encontrado');
                }
                $request->merge(['type' => $type->id]);
            }
            $document_name = '';
            if (File($request->document)) {
                $document_name = str_replace('', '_', time() . '-' . $request->document->getClientOriginalName());
                // Storage::disk('s3')->put($document_name, $document);
                Storage::disk('local')->put($document_name, $request->document);
            }
            $request->merge(['url_document' => $document_name]);

            $store_doc = $this->storeGuidanceDoc($request);
            if ($store_doc['state'] != 200) {
                DB::rollBack();
                return $store_doc;
            }
            // }
            DB::commit();
            // }
            return $this->respond(200, [], '', 'Documento almacenado de forma exitosa.');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }
}
