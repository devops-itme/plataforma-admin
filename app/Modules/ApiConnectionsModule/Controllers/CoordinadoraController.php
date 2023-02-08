<?php

namespace App\Modules\ApiConnectionsModule\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\ApiConnectionsModule\Models\Coordinadora;
use Faker\Core\Coordinates;
use Illuminate\Http\Request;


class CoordinadoraController extends Controller
{
    use RestActions;

    public function generateGuide(Request $request){
        $Coordinadora = new Coordinadora;
        $petition = $Coordinadora->generateGuide($request);
        return $petition;
    }

    public function printLabels(Request $request){
        $Coordinadora = new Coordinadora;
        $petition = $Coordinadora->printLabels($request);
        return $petition;
    }

    public function schedulePickup(Request $request){
        $Coordinadora = new Coordinadora;
        $petition = $Coordinadora->schedulePickup($request);
        return $petition;
    }

    public function pickupTracking(Request $request){
        $Coordinadora = new Coordinadora;
        $petition = $Coordinadora->pickupTracking($request);
        return $petition;
    }

    public function getMethods(){
        $Coordinadora = new Coordinadora;
        $petition = $Coordinadora->getMethods();
        return $petition;
    }

    /* public function token()
    {
        return csrf_token(); 
    } */
}
