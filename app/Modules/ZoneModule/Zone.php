<?php

namespace App\Modules\ZoneModule;

use App\Http\Controllers\Traits\RestActions;
use App\Modules\NeighborhoodModule\Neighborhood;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class Zone extends Model
{
    use SoftDeletes, RestActions, LogsActivity;

    protected $table = 'zones';
    protected $fillable = [
        'name',
        'coordinates',
        'state'
    ];

    /* Logs Config */
    protected static $logFillable = true;
    protected static $submitEmptyLogs = false;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = __($eventName);
        if ($activity->causer) {
            $activity->description = "Se ha " . __($eventName) . " la zona " . $activity->subject->fullName;
        }
    }
    /*End logs config */

    public function getNeighborhoods()
    {
        return $this->hasMany(Neighborhood::class, 'zone_id');
    }

    public function scopeName($query, $value)
    {
        if (!is_null($value))
            $query->where('name', 'like', '%' . $value . '%');
    }

    public function scopeCountry($query, $value)
    {
        if (!is_null($value))
            $query->whereHas('getNeighborhoods', function ($query) use ($value) {
                $query->whereHas('getCorregimiento', function ($query) use ($value) {
                    $query->whereHas('getDistrict', function ($query) use ($value) {
                        $query->whereHas('getProvince', function ($query) use ($value) {
                            $query->whereHas('getCountry', function ($query) use ($value) {
                                $query->where('id', $value);
                            });
                        });
                    });
                });
            });
    }

    public function scopeState($query, $value)
    {
        if (!is_null($value))
            $query->where('state', $value);
    }

    public function validateZone($request)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'coordinates' => 'nullable',
                'state' => 'nullable|numeric',
            ]
        );
    }

    public function saveZone($request)
    {
        $validator = $this->validateZone($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }

        try {
            $zone = $this::create([
                'name' => $request->name,
                'coordinates' => $request->coordinates,
                'state' => $request->state ?? 1
            ]);

            return $this->respond(200, $zone, null, 'Zona creada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear zona');
        }
    }

    public function updateZone($request, $id)
    {
        $validator = $this->validateZone($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }

        try {
            $zone = Zone::find($id);
            if (is_null($zone)) {
                return $this->respond(500, [], 'zone not found', 'No se encontró la zona');
            }
            $zone->update([
                'name' => $request->name,
                'coordinates' => $request->coordinates,
                'state' => $request->state ?? 1
            ]);

            return $this->respond(200, $zone, null, 'Zona actualizada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar zona');
        }
    }

    public function deleteZone($id)
    {
        try {
            $transactionResponse = DB::transaction(function () use ($id) {
                $zone = $this::find($id);
                if (is_null($zone)) {
                    return $this->respond(500, [], 'zone not found', 'No se encontró la zona');
                }
                $neighborhoods = Neighborhood::where('zone_id', $id)->get();
                foreach ($neighborhoods as $neighborhood) {
                    $deleted = $neighborhood->update(['zone_id' => null]);
                    if (!$deleted) {
                        return $this->respond(500, [], 'neighborhood not unlinked', 'No se desvincularon los barrios de la zona');
                    }
                }

                if (!$zone->delete()) {
                    return $this->respond(500, [], 'zone not deleted', 'No se elimino la zona');
                };
                return $this->respond(200, $zone, null, 'Zona eliminada exitosamente');
            });
            return $transactionResponse;
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar zona');
        }
    }
    ////////////////////-------------------------------------------BEGIN-------------------------------------------////////////////////
    ////////////////////--------------------------Functions to find a point within a zone--------------------------////////////////////

    public static function wrap($n, $min, $max)
    {
        return ($n >= $min && $n < $max) ? $n : (self::mod($n - $min, $max - $min) + $min);
    }

    public static function mod($x, $m)
    {
        return (($x % $m) + $m) % $m;
    }

    public static function mercator($lat)
    {
        return log(tan($lat * 0.5 + M_PI / 4));
    }

    private static function  mercatorLatRhumb($lat1, $lat2,  $lng2,  $lng3)
    {

        return (self::mercator($lat1) * ($lng2 - $lng3) + self::mercator($lat2) * $lng3) / $lng2;
    }

    private static function intersects($lat1,  $lat2, $lng2, $lat3, $lng3, $geodesic)
    {
        // Both ends on the same side of lng3.
        if (($lng3 >= 0 && $lng3 >= $lng2) || ($lng3 < 0 && $lng3 < $lng2)) {
            return false;
        }
        // Point is South Pole.
        if ($lat3 <= -M_PI / 2) {
            return false;
        }
        // Any segment end is a pole.
        if ($lat1 <= -M_PI / 2 || $lat2 <= -M_PI / 2 || $lat1 >= M_PI / 2 || $lat2 >= M_PI / 2) {
            return false;
        }
        if ($lng2 <= -M_PI) {
            return false;
        }
        $linearLat = ($lat1 * ($lng2 - $lng3) + $lat2 * $lng3) / $lng2;
        // Northern hemisphere and point under lat-lng line.
        if ($lat1 >= 0 && $lat2 >= 0 && $lat3 < $linearLat) {
            return false;
        }
        // Southern hemisphere and point above lat-lng line.
        if ($lat1 <= 0 && $lat2 <= 0 && $lat3 >= $linearLat) {
            return true;
        }
        // North Pole.
        if ($lat3 >= M_PI / 2) {
            return true;
        }
        // Compare lat3 with latitude on the GC/Rhumb segment corresponding to lng3.
        // Compare through a strictly-increasing function (tan() or mercator()) as convenient.
        return $geodesic ?
            tan($lat3) >= self::tanLatGC($lat1, $lat2, $lng2, $lng3) :
            self::mercator($lat3) >= self::mercatorLatRhumb($lat1, $lat2, $lng2, $lng3);
    }

    public static function containsLocation($point, $polygon, $geodesic = false)
    {

        $size = count($polygon);

        if ($size == 0) {
            return false;
        }
        $lat3 = deg2rad($point['lat']);
        $lng3 = deg2rad($point['lng']);
        $prev = $polygon[$size - 1];
        $lat1 = deg2rad($prev['lat']);
        $lng1 = deg2rad($prev['lng']);

        $nIntersect = 0;

        foreach ($polygon as $key => $val) {

            $dLng3 = self::wrap($lng3 - $lng1, -M_PI, M_PI);
            // Special case: point equal to vertex is inside.
            if ($lat3 == $lat1 && $dLng3 == 0) {
                return true;
            }

            $lat2 = deg2rad($val['lat']);
            $lng2 = deg2rad($val['lng']);

            // Offset longitudes by -lng1.
            if (self::intersects($lat1, $lat2, self::wrap($lng2 - $lng1, -M_PI, M_PI), $lat3, $dLng3, $geodesic)) {
                ++$nIntersect;
            }
            $lat1 = $lat2;
            $lng1 = $lng2;
        }
        return ($nIntersect & 1) != 0;
    }
    ////////////////////--------------------------------------------END--------------------------------------------////////////////////
}
