<?php

namespace App\Http\Controllers\Api;

use App\Guide;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    use RestActions;
    public function index(Request $request)
    {
        try {
            $guides = Guide::where('order_id', $request->order_id)->get();
            return $this->respond(200, $guides, null, 'Guiás asignadas');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }
}
