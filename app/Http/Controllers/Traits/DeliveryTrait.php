<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\Traits\RestActions as TraitsRestActions;
use App\Messenger;
use App\Order;
use App\ParameterValue;
use App\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait DeliveryTrait
{
    use TraitsRestActions;


    public function guideAssignment($request)
    {
        try {
            $route = Route::create([
                'guide_id' => $request->guide_id,
                'messenger_user_id' => $request->user_id
            ]);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
}
