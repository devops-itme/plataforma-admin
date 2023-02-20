<?php

namespace App\Modules\OrderModule\Controllers;

use Illuminate\Http\Request;
use App\Modules\OrderModule\CoordinadoraOrder;
use App\Modules\OrderModule\CoordinadoraOrderDetail;
use App\Http\Controllers\Controller;

class CoordinadoraOrderDetailController extends Controller
{
    public function createGuide(Request $request)
    {
        $Coordinadora = new CoordinadoraOrder;
        $petition = $Coordinadora->createCoordinadoraGuide($request);
        return $petition;
    }

    public function createProduct(Request $request, $id)
    {
        $Coordinadora = new CoordinadoraOrderDetail();
        $petition = $Coordinadora->createProduct($request, $id);
        return $petition;
    }
}
