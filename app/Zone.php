<?php

namespace App;

use App\Http\Controllers\Traits\RestActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Zone extends Model
{
    use SoftDeletes, RestActions;

    protected $table = 'zones';
    protected $fillable = [
        'name',
        'state'
    ];

    public function getNeighborhoods()
    {
        return $this->hasMany(Neighborhood::class, 'zone_id');
    } 

    public function validateZone($request)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
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
            $user = $this::create([
                'name' => $request->name,
                'state' => $request->state ?? 1
            ]);

            return $this->respond(200, $user, null, 'Zona creada exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear zona');
        }
    }
}
