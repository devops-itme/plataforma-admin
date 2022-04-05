<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RatesTrait;
use App\ParameterValue;
use App\Rate;
use App\Zone;
use Illuminate\Http\Request;

class RateController extends Controller
{
    use RatesTrait;
    
    public function index()
    {
        $rates = Rate::paginate(10);        
     
        return view('tarifario.list', compact('rates'));
    }

    public function create()
    {
        $package_types = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'package_type');
        })->get();

        $zones = Zone::get();

        return view('tarifario.create', compact('package_types', 'zones'));
    }

    public function store(Request $request)
    {
        $rateResponse = $this->saveRate($request);

        if ($rateResponse['state'] != 200) {
            return redirect()->back()->withInput()->with('danger', $rateResponse['message']);
        }
        return redirect()->route('orders.index')->with('success', $rateResponse['message']);
    }
}
