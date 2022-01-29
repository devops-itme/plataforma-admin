<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\RestActions;
use App\Http\Controllers\Traits\RestActions as TraitsRestActions;
use App\Messenger;
use App\ParameterValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\UserTrait;
use Illuminate\Support\Facades\Validator;

trait MessengerTrait
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


        $validator = Validator::make($request->all(), [
            'vehicle_plate' => 'required',
            'admission_date' => 'required',
            'production_percentage' => 'required|numeric',
            'exclusive' => 'required',
            'contract' => 'required|mimes:pdf,jpg,JPG,png,PNG,jpeg,JPEG|max:10000'

        ]);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }

        request()->merge(['role' => 3, 'state' => 1,]);

        if ($request->hasFile('contract')) {
            $contract = $request->file('contract');
            $contract_file = time() . '-' . $contract->getClientOriginalName();
            // \Storage::disk('local')->put($document_file,  \File::get($contract));
        }

        try {
            $user = $this->saveUser($request);
            $user = $user['data'];
            $messenger = Messenger::create([
                'user_id' => $user->id,
                'vehicle_plate' => $request->vehicle_plate,
                'admission_date' => $request->admission_date,
                'production_percentage' => $request->production_percentage,
                'exclusive' => $request->exclusive,
                'contract' => $contract_file
            ]);
            return $this->respond(200, $messenger);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
}
