<?php

namespace App\Modules\ZoneModule\Controllers;



use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\CorregimientoModule\Corregimiento;
use App\Modules\CountryModule\Country;
use App\Modules\DistrictModule\District;
use App\Modules\NeighborhoodModule\Neighborhood;
use App\Modules\ProvinceModule\Province;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    use RestActions;

    protected $neighborhoodRelationships = [
        'getCorregimiento',
        'getCorregimiento.getDistrict',
        'getCorregimiento.getDistrict.getProvince',
        'getCorregimiento.getDistrict.getProvince.getCountry',
    ];

    public function getPlaces(Request $request)
    {
        try {
            $place_type = $request->place_type;
            $place_id = $request->place_id;
            $place = [];
            switch ($place_type) {
                case 'country':
                    $place = Country::get();
                    break;
                case 'province':
                    $place = Province::country($place_id)->get();
                    break;
                case 'district':
                    $place = District::province($place_id)->get();
                    break;
                case 'corregimiento':
                    $place = Corregimiento::district($place_id)->get();
                    break;
                case 'neighborhood':
                    $place = Neighborhood::corregimiento($place_id)->get();
                    break;
                case 'zone_neighborhoods':
                    $place = Neighborhood::zone($place_id)->get();
                    break;
                default:
                    break;
            }
            return $this->respond(200, $place, null, 'Lugares');
        } catch (\Throwable $th) {
            return $this->respond(200, null, $th->getMessage(), 'Error de servidor');;
        }
    }

    public function getZoneNeighborhoods($id)
    {
        try {
            $place = Neighborhood::zone($id)->with($this->neighborhoodRelationships)->get();
            return $this->respond(200, $place, null, 'Barrios de la zona');
        } catch (\Throwable $th) {
            return $this->respond(200, null, $th->getMessage(), 'Error de servidor');;
        }
    }
}
