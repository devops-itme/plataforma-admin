<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Neighborhood;
use App\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ZoneController extends Controller
{
    use RestActions;

    public function index()
    {
        $zones = Zone::paginate(5);
        return view('zones.index', compact('zones'));
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
            return $this->respond(500, null, $e->getMessage() . '. Line: ' . $e->getLine(), 'Error del servidor');
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
