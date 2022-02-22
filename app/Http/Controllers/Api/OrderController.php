<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use RestActions;

    public function index(Request $request)
    {
        $messenger_user_id = $request->messenger_user_id ?? Auth::user()->id;
        try {
            $routes = Route::where('messenger_user_id',$messenger_user_id)->get();
            return $this->respond(200, $routes, null, 'Ordenes asignadas');
        } catch (\Throwable $e) {
            return $this->respond(500, null, $e->getMessage(), 'Error del servidor');
        }
    }
}
