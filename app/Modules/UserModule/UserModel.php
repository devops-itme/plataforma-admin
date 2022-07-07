<?php

namespace App\Modules\UserModule;

use App\Http\Controllers\Traits\RestActions;
use App\Modules\CustomerModule\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserModel extends User
{
    use RestActions;

    public function deleteAccount($user_id = null, $eliminator_user_id = null)
    {
        if (is_null($user_id)) {
            $user_id = Auth::user()->id;
        }
        if (is_null($eliminator_user_id)) {
            $eliminator_user_id = Auth::user()->id;
        }
        try {
            $user = User::find($user_id);
            $customer = Customer::where('user_id', $user_id)->first();
            if (is_null($user) || is_null($customer)) {
                $this->respond(404, $user, 'user not found', 'Usuario no encontrado');
            }
            DB::beginTransaction();
            $user->update(['deleted_by' => $eliminator_user_id]);
            $user->delete();
            $customer->delete();
            $user->tokens()->delete();
            DB::commit();
            return $this->respond(200, $user, null, 'Cuenta eliminada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar cuenta');
        }
    }
}
