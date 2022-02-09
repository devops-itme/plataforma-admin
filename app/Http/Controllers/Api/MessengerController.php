<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MessengerTrait;
use App\Http\Controllers\Traits\RestActions;
use App\Http\Controllers\Traits\UserTrait;
use App\Messenger;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessengerController extends Controller
{
    use RestActions, UserTrait, MessengerTrait;

    public function show()
    {
        $user_id = Auth::user()->id;
        if (is_null($user_id)) {
            return $this->respond(401,  null, 'Unauthorized', 'Acceso denegado');
        }
        try {
            $user = User::where('id', $user_id)->with('getMessenger')->first();
            return $this->respond(200, $user, null, 'Datos del mensajero');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }

    public function update(Request $request)
    {
        $user_id = Auth::user()->id;
        if (is_null($user_id)) {
            return $this->respond(401,  null, 'Unauthorized', 'Acceso denegado');
        }
        try {
            $messenger = Messenger::where('user_id', $user_id)->first();
            $messenger_id = $messenger->id;
            $response = $this->updateMessenger($request, $messenger_id);
            return $response;
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Ha ocurrido un error de servidor');
        }
    }
}
