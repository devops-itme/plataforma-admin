<?php

namespace App;

use App\Http\Controllers\Traits\RestActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ZoneCoordinate extends Model
{
    use SoftDeletes, RestActions;

    protected $table = 'zone_coordinates';
    protected $fillable = [
        'zone_id',
        'lat',
        'lng'
    ];

    public function validateZoneCoordinate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'zone_id' => 'required|numeric|exists:zones,id',
                'state' => 'nullable|numeric',
                'lat' => 'required',
                'lng' => 'required',
            ]
        );
    }

    public function saveZoneCoordinate($request)
    {
        $validator = $this->validateZoneCoordinate($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }

        try {
            $user = $this::create([
                'zone_id' => $request->zone_id,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'state' => $request->state ?? 1
            ]);

            return $this->respond(200, $user, null, 'Polígono de zona creada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear Polígono de zona');
        }
    }
}
