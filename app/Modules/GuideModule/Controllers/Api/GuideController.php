<?php

namespace App\Modules\GuideModule\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuideResource;
use App\Modules\GuideModule\Controllers\GuideTrait;
use App\Modules\GuideModule\Guide;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    use GuideTrait;

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
        try {
            $guides = Guide::where('order_id', $request->order_id)
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
}
