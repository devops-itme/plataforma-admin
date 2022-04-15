<?php

namespace App\Modules\ZoneModule\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\CountryModule\Country;
use App\Modules\NeighborhoodModule\Neighborhood;
use App\Modules\ZoneModule\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ZoneController extends Controller
{
    use RestActions;

    protected $path = 'ZoneModule.views.html.';

    protected $zoneRelationships = [
        'getNeighborhoods',
        'getNeighborhoods.getCorregimiento',
        'getNeighborhoods.getCorregimiento.getDistrict',
        'getNeighborhoods.getCorregimiento.getDistrict.getProvince',
        'getNeighborhoods.getCorregimiento.getDistrict.getProvince.getCountry',
    ];

    public function index()
    {
        $countries = Country::get();

        $zones = Zone::name(request()->name)
            ->country(request()->country)
            ->state(request()->state)
            ->paginate(5);

        return view($this->path . 'index', compact('zones', 'countries'));
    }

    public function edit($id)
    {
        $zone = Zone::where('id', $id)->with($this->zoneRelationships)->first();
        return $this->respond(200, $zone, 'detail zone', 'Información de la zona');
    }

    public function store(Request $request)
    {
        try {
            $zone = new Zone();
            $transactionResponse = DB::transaction(function () use ($request, $zone) {
                $zoneResponse = $zone->saveZone($request);
                if ($zoneResponse['state'] != 200) {
                    return $zoneResponse;
                }

                $zone_id = $zoneResponse['data']->id;

                foreach ($request->neighborhood as $hood) {
                    $field = ['zone_id' => $zone_id];

                    $neighborhood = Neighborhood::find($hood)
                        ->update($field);

                    if (!$neighborhood) {
                        return $this->respond(500, null, 'Neighborhood' . $hood . 'no updated', 'Error del servidor');
                    };
                }
                return $zoneResponse;
            });
            $status = $transactionResponse['state'] == 200 ? 'success' : 'danger';
            return redirect()->back()->withInput()->with($status, $transactionResponse['message']);
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('danger', 'Error del servidor');
            // return $this->respond(500, null, $e->getMessage() . '. Line: ' . $e->getLine(), 'Error del servidor');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $zone = new Zone();
            $transactionResponse = DB::transaction(function () use ($request, $id, $zone) {
                $zoneResponse = $zone->updateZone($request, $id);
                if ($zoneResponse['state'] != 200) {
                    return $zoneResponse;
                }

                $zone_id = $zoneResponse['data']->id;

                foreach ($request->neighborhood as $hood) {
                    $field = ['zone_id' => $zone_id];

                    $neighborhood = Neighborhood::find($hood)
                        ->update($field);

                    if (!$neighborhood) {
                        return $this->respond(500, null, 'Neighborhood' . $hood . 'no updated', 'Error del servidor');
                    };
                }
                return $zoneResponse;
            });
            $status = $transactionResponse['state'] == 200 ? 'success' : 'danger';
            return redirect()->back()->withInput()->with($status, $transactionResponse['message']);
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('danger', 'Error del servidor');
            // return $this->respond(500, null, $e->getMessage() . '. Line: ' . $e->getLine(), 'Error del servidor');
        }
    }

    public function destroy(Request $request, $id)
    {
        $zone = new Zone();
        $zoneResponse = $zone->deleteZone($id);
        if ($request->response_format == 'json') {
            return $zoneResponse;
        }
        if ($zoneResponse['state'] == 200) {
            return redirect()->route('rates.index')->with('success', $zoneResponse['message']);
        } else {
            return redirect()->back()->with('danger', $zoneResponse['message']);
        }
    }
}
