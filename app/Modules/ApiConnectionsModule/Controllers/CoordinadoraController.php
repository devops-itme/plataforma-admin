<?php

namespace App\Modules\ApiConnectionsModule\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\ApiConnectionsModule\Models\Coordinadora;
use Illuminate\Http\Request;


class CoordinadoraController extends Controller
{
    use RestActions;

    public function testConnection(){
        $Coordinadora = new Coordinadora;
        $petition = $Coordinadora->testConnection();
        return $petition;
    }

    public function generateGuide(){
        $Coordinadora = new Coordinadora;
        $petition = $Coordinadora->generateGuide();
        return $petition;
    }
}
