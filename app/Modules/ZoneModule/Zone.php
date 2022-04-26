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
}
