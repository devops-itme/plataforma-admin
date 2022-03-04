<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\RestActions;
use App\Http\Controllers\Traits\RestActions as TraitsRestActions;
use App\Messenger;
use App\ParameterValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\UserTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait MessengerTrait
{
    use UserTrait;

    public function messengerValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'vehicle_plate' => 'required',
                'admission_date' => 'required',
                'production_percentage' => 'required|numeric',
                'exclusive' => 'required',
                'contract_type_id' => 'required',
                'document_type' => 'required',
                'document_number' => 'required',
                'name' => 'required',
                'last_name' => 'required'
                // 'contract' => 'required',
            ]
        );
    }
    public function getMessengers()
    {
        try {
            $messengers = Messenger::with('user')
                ->name(request()->name)
                ->document(request()->document)
                ->email(request()->email)
                ->phone(request()->phone)
                ->plate(request()->vehicle_plate)
                ->state(request()->state)
                ->paginate(10);
            return $this->respond(200, $messengers);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
    public function showMessenger($id)
    {
        try {
            $messengers = Messenger::where('id', $id)->with(['user', 'getContractType'])->first();
            return $this->respond(200, $messengers);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }


    public function saveMessenger($request, $id)
    {

        $validator = $this->messengerValidate($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(),  $validator->errors()->first());
        }
        try {

            $contract_file = null;
            if ($request->hasFile('contract')) {
                $contract = $request->file('contract');
                $contract_file = time() . '-' . $contract->getClientOriginalName();
                // \Storage::disk('local')->put($document_file,  \File::get($contract));
            }
            $messenger = Messenger::create([
                'user_id' => $id,
                'vehicle_plate' => $request->vehicle_plate,
                'admission_date' => $request->admission_date,
                'production_percentage' => $request->production_percentage,
                'exclusive' => $request->exclusive,
                'birth_date' => $request->birth_date,
                'contract' => $contract_file,
                'contract_type_id' => $request->contract_type_id
            ]);
            return $this->respond(200, $messenger);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }

    public function updateMessenger($request, $id)
    {

        try {
            if ($request->hasFile('contract')) {
                $contract = $request->file('contract');
                $contract_file = time() . '-' . $contract->getClientOriginalName();
                // \Storage::disk('local')->put($document_file,  \File::get($contract));
            }
            if (!empty($contract_file)) {
                $request->contract = $contract_file;
            }

            $messenger = Messenger::find($id);
            $messenger->update($request->all());

            $updateUser = $this->updateUser($request->merge(['user_id' => $messenger->user_id]), $id);
            if ($updateUser['state'] == 500) {
                return $this->respond(500, [], $updateUser['error'], $updateUser['message']);
            }
            return $this->respond(200, null, null, 'Mensajero actualizado exitosamente');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }

    public function deleteMessenger($id)
    {
        try {
            $customer = Messenger::find($id);
            if (is_null($customer)) {
                return $this->respond(500, [], 'user not found', 'No se encontró el mensajero');
            }
            $deleteUser = $this->deleteUser($customer->user_id);
            if ($deleteUser['state'] == 500) {
                return $this->respond(500, [], $deleteUser['error'], $deleteUser['message']);
            }
            $customer->delete();
            return $this->respond(200, $customer, null, 'Mensajero eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar mensajero');
        }
    }
}
