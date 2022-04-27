<?php

namespace App\Modules\ZoneModule\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\ZoneModule\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{
    use RestActions;

    // protected $path = 'ZoneModule.views.html.';

    public function searchZone(Request $request)
    {
        try {
            $Zone = new Zone();

            $validator = Validator::make(
                $request->all(),
                [
                    'lat' => 'required',
                    'lng' => 'required',
                ]
            );

            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
            }

            $lat = $request->lat;
            $lng = $request->lng;
            $point = ['lat' => $lat, 'lng' => $lng];

            $zones = Zone::get(['id', 'coordinates']);

            $zone_id = 0;
            foreach ($zones as $zone) {
                $coordinates = json_decode($zone->coordinates);
                $polygon = [];
                foreach ($coordinates as $coordinate) {
                    $polygon[] = ['lat' => $coordinate->lat, 'lng' => $coordinate->lng];
                }
                $contain = $Zone::containsLocation($point, $polygon);
                $contain && $zone_id = $zone->id;
            };

            $state = $zone_id ? 200 : 404;
            $data = $zone_id ? ['zone_id' => $zone_id] : null;
            $message = $zone_id ? 'Zona encontrada exitosamente' : 'No contamos con cobertura para esta dirección';

            return $this->respond($state, $data, null, $message);
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al buscar la zona');
        }

        // para german
        // view($this->path . 'search-zone', compact('lat', 'lng', 'zones'));
    }
}
