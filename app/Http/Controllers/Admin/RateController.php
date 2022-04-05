<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ParameterValue;
use App\Zone;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function create()
    {
        $package_types = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'package_type');
        })->get();
       
        $zones = Zone::get();

        return view('tarifario.index', compact('package_types', 'zones'));
    }

    public function store(Request $request)
    {
        $rateResponse = $this->saveRate($request);
        return $rateResponse;
    }
}
