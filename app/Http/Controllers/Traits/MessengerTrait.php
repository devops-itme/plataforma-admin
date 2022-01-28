<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\RestActions;
use App\Http\Controllers\Traits\RestActions as TraitsRestActions;
use App\Messenger;
use App\ParameterValue;
use Illuminate\Http\Request;


trait MessengetTrait
{
    use TraitsRestActions;

    public function getMessenger(Request $request)
    {
        try {
            $messengers = Messenger::all();

            return $this->respond(200, $messengers);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
