<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessengerController extends Controller
{
    use RestActions;
    public function show()
    {
        $user_id = Auth::user()->id;
        try {
            $user = User::where('id', $user_id)->with('getMessenger')->first();
            return $this->respond(200, $user, null, 'Datos del mensajero');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }
}
