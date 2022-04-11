<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RatesTrait;
use App\Neighborhood;
use App\ParameterValue;
use App\Rate;
use App\Zone;
use Illuminate\Http\Request;

class RateController extends Controller
{
    use RatesTrait;

    public function index()
    {
        // $model = new Rate();
        // return $model->calculateRate(1, 75, 79);
        $rates = Rate::packageType(request()->package_type)
            ->baseValue(request()->base_value)
            ->packageType(request()->package_type)
            ->zone(request()->zone_id)
            ->neighborhood(request()->neighborhood_id)
            ->state(request()->state)
            ->paginate(12);

        $package_types = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'package_type');
        })->get();

        $zones = Zone::get();

        $neighborhoods = Neighborhood::get();

        return view('rates.index', compact('rates', 'package_types', 'zones', 'neighborhoods'));
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

    public function edit($id)
    {
        $rate = Rate::find($id);
        $package_types = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'package_type');
        })->get();
        $zones = Zone::get();
        $neighborhoods = Neighborhood::where('zone_id', $rate->zone_id)->get();

        return view('rates.edit', compact('rate', 'package_types', 'zones', 'neighborhoods'));
    }

    public function update(Request $request, $id)
    {
        $special_rate_value = $request->special_rate == 'on' ? 1 : 0;
        $request->merge(['special_rate' => $special_rate_value]);
        $rateResponse = $this->updateRate($request, $id);
        $status = $rateResponse['state'] == 200 ? 'success' : 'danger';

        return redirect()->back()->with($status, $rateResponse['message']);
    }

    public function destroy(Request $request, $id)
    {
        $rateResponse = $this->deleteRate($id);
        if ($request->response_format == 'json') {
            return $rateResponse;
        }
        $status = $rateResponse['state'] == 200 ? 'success' : 'danger';
        return redirect()->back()->with($status, $rateResponse['message']);
    }
}
