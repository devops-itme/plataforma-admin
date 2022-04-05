<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RatesTrait;
use App\ParameterValue;
use App\Zone;
use Illuminate\Http\Request;

class RateController extends Controller
{
    use RatesTrait;

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
        return $rateResponse = $this->saveRate($request);

        if ($rateResponse['state'] != 200) {
            return redirect()->back()->with('danger', $rateResponse['message']);
        }
        return redirect()->route('orders.index')->with('success', $rateResponse['message']);
    }
}
