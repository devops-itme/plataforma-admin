<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Modules\ApiConnectionsModule\Models\ApiSync;
class LoginSuccessful
{   
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {   
        $ApiSync = new ApiSync;
        $userData = auth()->user();
        $event->subject = 'login';
        $event->description = 'Inicio de Sesión';
        activity($event->subject)
            ->by($event->user)
            ->log($event->description);

        $ApiSync->ApiSaveLog(
            "Multientrega_Admin",
            array(
                'origin_user' => $userData->email ?? null
            ),
            "Multientrega_Admin",
            array(
                'destination_action' => "login"
            ),
            array(
                null
            ),
            array(
                'response' => "logged_in_successfully"
            ),
            "ACK"
        );
    }
}
