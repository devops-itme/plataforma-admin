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

        return view('rates.index', compact('rates'));
    }

    public function show($id)
    {
        $rate = Rate::find($id);
        return view('rates.detail', compact('rate'));
    }

    public function create()
    {
        $package_types = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'package_type');
        })->get();

        $zones = Zone::get();

        return view('rates.create', compact('package_types', 'zones'));
    }

    public function store(Request $request)
    {
        $special_rate_value = $request->special_rate == 'on' ? 1 : 0;
        $request->merge(['special_rate' => $special_rate_value]);
        $rateResponse = $this->saveRate($request);

        if ($rateResponse['state'] != 200) {
            return redirect()->back()->withInput()->with('danger', $rateResponse['message']);
        }
        return redirect()->route('rates.index')->with('success', $rateResponse['message']);
    }
}
