<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Modules\UserModule\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => [
                'required',
                'string',
                Rule::exists('users', $this->username())->where('state', 1),
            ],
            'password' => 'required|string',
        ], [
            $this->username() . '.exists' => 'El usuario no esta activo'
        ]);

        $message = 'Su rol se encuentra inhabilitado';
        $is_numeric = is_numeric($request->email);

        $field = $is_numeric ? 'phone' : 'email';

        $user = User::where($field, $request->email)->first();
        if (is_null($user)) {
            $message = 'Su usuario se encuentra inhabilitado';
        }

        $active = ($user->getRole->state ?? false) == 1 && $user->getRole->deleted_at == NULL;

        if (!$active) {
            $request->validate(
                [
                    'active' => 'required'
                ],
                [
                    'active.required' => $message
                ]
            );
        }
    }
}
