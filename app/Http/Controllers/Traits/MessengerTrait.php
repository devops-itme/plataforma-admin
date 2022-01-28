<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\RestActions;
use App\Http\Controllers\Traits\RestActions as TraitsRestActions;
use App\Messenger;
use App\ParameterValue;
use Illuminate\Http\Request;
use UserTrait;

trait MessengetTrait
{
    use TraitsRestActions, UserTrait;

    public function getMessengers()
    {
        try {
            $messengers = Messenger::with('user')->all();
            return $this->respond(200, $messengers);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }

    public function saveMessenger(Request $request)
    {

        $request->validate([
            'vehicle_plate' => 'required',
            'admission_date' => 'required',
            'production_percentage' => 'required',
            'contact' => 'required',
            'exclusive' => 'required',
        ]);

        try {
            $user = $this->saveUser($request);
            $user = $user['data'];
            $messenger = Messenger::create([
                'user_id' => $user->id,
            ]);
            return $this->respond(200, $messenger);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
}
