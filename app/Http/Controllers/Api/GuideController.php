<?php

namespace App\Http\Controllers\Api;

use App\Guide;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    use RestActions;

    protected $messengerRelationships = [
        'getRoute', 'getRoute.getMessenger', 'getRoute.getMessenger.getMessenger',
    ];
    
    public function index(Request $request)
    {
        try {
            $guides = Guide::where('order_id', $request->order_id)
            ->with($this->messengerRelationships)->get();
            return $this->respond(200, $guides, null, 'Guías asignadas');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
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
}
