<?php

namespace App\Modules\ApiConnectionsModule\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\ApiConnectionsModule\Models\Coordinadora;
use Faker\Core\Coordinates;
use Illuminate\Http\Request;
use App\Modules\OrderModule\CoordinadoraOrder;


class CoordinadoraController extends Controller
{
    use RestActions;

    public function authenticate()
    {
        $Coordinadora = new Coordinadora;
        $petition = $Coordinadora->authenticate();
        return $petition;
    }


    public function generateGuides(/* Request $request, */ $order_id){
        
        $Coordinadora = new Coordinadora();
        $Order = new CoordinadoraOrder();
        $guidesData = $Order->getCoordinadoraGuidesByOrder($order_id)['data'];
        
        return 1;
        $Coordinadora->authenticate();
        foreach ($guidesData as $guide) {
            $sendGuide = $Coordinadora->generateGuide($guide);
            
            if ($sendGuide['state'] != 200) {
                return redirect()->back()->with('success', 'Hubo un fallo: '.$sendGuide['error'].'');
            }
        }
        return redirect()->back()->with('success', 'Guías enviadas correctamente');
       /*  $Coordinadora = new Coordinadora;
        $getToken = $Coordinadora->authenticate();
        $petition = $Coordinadora->generateGuide($request);
        return $petition; */
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
