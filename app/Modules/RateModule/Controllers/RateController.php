<?php

namespace App\Modules\RateModule\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\RatesImport;
use App\Modules\NeighborhoodModule\Neighborhood;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\RateModule\Controllers\RatesTrait;
use App\Modules\RateModule\Rate;
use App\Modules\ZoneModule\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\Securities\Rates;

class RateController extends Controller
{
    use RatesTrait;

    protected $path = 'RateModule.views.html.';

    public function index()
    {
        $rates = Rate::packageType(request()->package_type)
            ->baseValue(request()->base_value)
            ->packageType(request()->package_type)
            ->whereZone(request()->zone_id)
            ->neighborhood(request()->neighborhood_id)
            ->state(request()->state)
            ->paginate(12);

        $package_types = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'package_type');
        })->get();

        $zones = Zone::get();

        $neighborhoods = Neighborhood::get();

        return view($this->path . 'index', compact('rates', 'package_types', 'zones', 'neighborhoods'));
    }

    public function show($id)
    {
        $rate = Rate::find($id);
        return view($this->path . 'detail', compact('rate'));
    }

    public function create()
    {
        $package_types = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'package_type');
        })->get();

        $zones = Zone::get();

        return view($this->path . 'create', compact('package_types', 'zones'));
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

        return view($this->path . 'edit', compact('rate', 'package_types', 'zones', 'neighborhoods'));
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

    public function importRate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required | mimes:xlsx',
        ]);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        if ($request->hasFile('file')) {
            $file_import = $request->file('file');
            Excel::import(new RatesImport(), $file_import);
            return $this->respond(200,  [], null, 'Importación de tarifas completada');
        }
        return $this->respond(500,  [], '', 'Error al importar archivo');
    }
}
