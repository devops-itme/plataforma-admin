<?php

namespace App\Modules\OrderModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\ParameterValueModule\ParameterValue;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use App\Modules\OrderModule\CoordinadoraOrderDetail;
use App\Modules\OrderModule\Order;
use App\Modules\ApiConnectionsModule\Models\Coordinadora;

class CoordinadoraOrder extends Model
{
    use RestActions, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coordinadora_guides';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        "external_id",
        "identificacion_destinatario",
        "nombres_destinatario",
        "apellidos_destinatario",
        "direccion_destinatario",
        "telefono_fijo_destinatario",
        "telefono_celular_destinatario",
        "codigo_ciudad_destinatario",
        "nombre_ciudad_destinatario",
        "codigo_pedido",
        "numero_pedido",
        "fechahora_pedido",
        "codigo_tienda",
        "es_entrega_mismo_dia",
        "valor_declarado",
        "order_id",
        "state",
        "status"
    ];

    public function getGuideDetails()
    {
        return $this->hasMany(CoordinadoraOrderDetail::class, 'guide_id');
    }

    public function validateGuide($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                "identificacion_destinatario" => 'nullable|numeric',
                "nombres_destinatario" => 'string',
                "apellidos_destinatario" => 'string',
                "direccion_destinatario" => 'required|string|min:10',
                "telefono_fijo_destinatario" => 'nullable|numeric',
                "telefono_celular_destinatario" => 'required|numeric',
                "codigo_ciudad_destinatario" => 'required|numeric',
                "nombre_ciudad_destinatario" => 'required|string',
                "codigo_pedido" => 'numeric',
                "numero_pedido" => 'numeric',
                "es_entrega_mismo_dia" => 'string|size:1',
                "valor_declarado" => 'numeric',
            ]
        );
    }

    public function createCoordinadoraGuide($request)
    {   
        $validate = $this->validateGuide($request);

        if ($validate->fails()) {
            return $this->respond(500, null, $validate->errors()->first(), "Error de validación");
        }

        try {
            $guide = $this::create([
                "external_id" => null,
                "order_id" => $request->order_id,
                "identificacion_destinatario" => $request->identificacion_destinatario,
                "nombres_destinatario" => $request->nombres_destinatario ?? null,
                "apellidos_destinatario" => $request->apellidos_destinatario ?? null,
                "direccion_destinatario" => $request->direccion_destinatario,
                "telefono_fijo_destinatario" => $request->telefono_fijo_destinatario ?? null,
                "telefono_celular_destinatario" => $request->telefono_celular_destinatario,
                "codigo_ciudad_destinatario" => $request->codigo_ciudad_destinatario,
                "nombre_ciudad_destinatario" => $request->nombre_ciudad_destinatario,
                "codigo_pedido" => $request->codigo_pedido,
                "numero_pedido" => $request->numero_pedido,
                "codigo_tienda" => "1",
                "es_entrega_mismo_dia" => $request->es_entrega_mismo_dia,
                "valor_declarado" => $request->valor_declarado,
                "status" => null,
                "state" => null
            ]);

            return $this->respond(201, $guide, null, "Guía creada exitósamente");
        } catch (\Throwable $th) {
            return $this->respond(500, null, $th->getMessage(), "Ocurrió un error inesperado");
        }
    }

    public function addGuideToBatch($request)
    {   
        $validate = $this->validateGuide($request);
        $orderDetail = new CoordinadoraOrderDetail();
        if ($validate->fails()) {
            return $this->respond(500, null, $validate->errors()->first(), "Error de validación");
        }

        try {
            $guide = $this::create([
                "external_id" => null,
                "order_id" => $request->order_id,
                "identificacion_destinatario" => $request->identificacion_destinatario,
                "nombres_destinatario" => $request->nombres_destinatario ?? null,
                "apellidos_destinatario" => $request->apellidos_destinatario ?? null,
                "direccion_destinatario" => $request->direccion_destinatario,
                "telefono_fijo_destinatario" => $request->telefono_fijo_destinatario ?? null,
                "telefono_celular_destinatario" => $request->telefono_celular_destinatario,
                "codigo_ciudad_destinatario" => $request->codigo_ciudad_destinatario,
                "nombre_ciudad_destinatario" => $request->nombre_ciudad_destinatario,
                "codigo_pedido" => $request->codigo_pedido,
                "numero_pedido" => $request->numero_pedido,
                "codigo_tienda" => "1",
                "es_entrega_mismo_dia" => $request->es_entrega_mismo_dia,
                "valor_declarado" => $request->valor_declarado,
                "status" => null,
                "state" => null
            ]);

            $guideDetail = $orderDetail->createProduct(new Request(array(
                "referencia" => $request->referencia,
                "unidades" => $request->unidades,
                "peso" => $request->peso,
                "alto" => $request->alto,
                "ancho" => $request->ancho,
                "largo" => $request->largo,
                "nombre_empaque" => $request->nombre_empaque,                
            )), $guide->id);

            
            return $this->respond(201, $guide, null, "Guía creada exitósamente");
        } catch (\Throwable $th) {
            return $this->respond(500, null, $th->getMessage(), "Ocurrió un error inesperado");
        }
    }

    public function createCoordinadoraGuideMassive(Request $request, $lot_number)
    {
        $validate = $this->validateGuide($request);

        if ($validate->fails()) {
            return $this->respond(500, null, $validate->errors()->first(), "Error de validación");
        }

        $getBatch = Order::where('order_number', $lot_number)->first();
        $batch_id = $getBatch->id;
        
        $guide = $this->where('codigo_pedido', $request->codigo_pedido)
                 ->where('order_id', '=', $batch_id)
                 ->get()->first();
        //dd($guide);
        if (!is_null($guide)) {
            return $this->respond(201, $guide, null, "guía encontrada");
        }
        
        try {
            $guide = $this::create([
                    "order_id" => $request->order_id,
                    "external_id" => null,
                    "identificacion_destinatario" => $request->identificacion_destinatario,
                    "nombres_destinatario" => $request->nombres_destinatario ?? null,
                    "apellidos_destinatario" => $request->apellidos_destinatario ?? null,
                    "direccion_destinatario" => $request->direccion_destinatario,
                    "telefono_fijo_destinatario" => $request->telefono_fijo_destinatario ?? null,
                    "telefono_celular_destinatario" => $request->telefono_celular_destinatario,
                    "codigo_ciudad_destinatario" => $request->codigo_ciudad_destinatario,
                    "nombre_ciudad_destinatario" => $request->nombre_ciudad_destinatario,
                    "codigo_pedido" => $request->codigo_pedido,
                    "numero_pedido" => $request->numero_pedido,
                    "fechahora_pedido" => null,
                    "codigo_tienda" => "1",
                    "es_pago_contra_entrega" => "N",
                    "es_entrega_mismo_dia" => $request->es_entrega_mismo_dia,
                    "valor_declarado" => $request->valor_declarado,
                    "status" => null,
                    "state" => null
                
            ]);
            return $this->respond(201, $guide, null, "Guía creada exitósamente");
        } catch (\Throwable $th) {
            return $this->respond(500, null, $th->getMessage(), "Ocurrió un error inesperado");
        }
    }

    public function getCoordinadoraGuides()
    {
        $coordinadoraGuides = $this::all();
        if (is_null($coordinadoraGuides)) {
            return $this->respond(404, null, "Guides not found", "No se hallaron guías");
        }

        return $this->respond(200, $coordinadoraGuides, null, "Guías obtenidas correctamente");
    }

    public function getCoordinadoraGuidesByOrder($order_id)
    {
        try {
            $guides = $this::with('getGuideDetails')->where('order_id', $order_id)->get();
            return $this->respond(200, $guides, null, "Guías obtenidas correctamente");
        } catch (\Throwable $th) {
            return $this->respond(200, null, $th->getMessage(), "Ocurrió un error inesperado");
        }
    }

    public function getCoordinadoraGuide($id)
    {
        $coordinadoraGuide = $this::find($id);
        if (is_null($coordinadoraGuide)) {
            return $this->respond(404, null, "Guide not found", "No se encontró la guía");
        }
        return $this->respond(200, $coordinadoraGuide, "Guide found", "Guía obtenida correctamente");
    }

    public function updateCoordinadoraGuide(Request $request, $id)
    {
        $validate = $this->validateGuide($request);
        $orderDetail = new CoordinadoraOrderDetail();
        $product_id = $request->product_id;

        if ($validate->fails()) {
            return $this->respond(500, null, $validate->errors()->first(), "Ocurrió un error de validación");
        }

        try {
            $guide = $this::find($id);
            if (is_null($guide)) {
                return $this->respond(404, null, "Guide not found", "Guía no encontrada");
            }
            if ($guide->external_id != null) {
                return $this->respond(500, null, "Canot update", "La guia ya fue generada, por lo que no es posible editarla");
            }
            $guide->update([
                "external_id" => $guide->external_id,
                "identificacion_destinatario" => $request->identificacion_destinatario ?? $guide->identificacion_destinatario,
                "nombres_destinatario" => $request->nombres_destinatario ?? $guide->nombres_destinatario,
                "apellidos_destinatario" => $request->apellidos_destinatario ?? $guide->apellidos_destinatario,
                "direccion_destinatario" => $request->direccion_destinatario ?? $guide->direccion_destinatario,
                "telefono_fijo_destinatario" => $request->telefono_fijo_destinatario ?? $guide->telefono_fijo_destinatario,
                "telefono_celular_destinatario" => $request->telefono_celular_destinatario ?? $guide->telefono_celular_destinatario,
                "codigo_ciudad_destinatario" => $request->codigo_ciudad_destinatario ?? $guide->codigo_ciudad_destinatario,
                "nombre_ciudad_destinatario" => $request->nombre_ciudad_destinatario ?? $guide->nombre_ciudad_destinatario,
                "codigo_pedido" => $request->codigo_pedido ?? $guide->codigo_pedido,
                "numero_pedido" => $request->numero_pedido ?? $guide->numero_pedido,
                "fechahora_pedido" => $guide->fechahora_pedido,
                "codigo_tienda" => $guide->codigo_tienda,
                "es_pago_contra_entrega" => $guide->es_pago_contra_entrega,
                "es_entrega_mismo_dia" => $request->entrega_mismo_dia ?? $guide->es_entrega_mismo_dia,
                "valor_declarado" => $request->valor_declarado ?? $guide->valor_declarado,
                "status" => $request->status ?? $guide->status,
                "state" => $guide->state
            ]);

            $guideDetail = $orderDetail->updateProduct(new Request(array(
                "referencia" => $request->referencia,
                "unidades" => $request->unidades,
                "peso" => $request->peso,
                "alto" => $request->alto,
                "ancho" => $request->ancho,
                "largo" => $request->largo,
                "nombre_empaque" => $request->nombre_empaque,                
            )), $product_id);
            
            return $this->respond(200, $guide, null, "Guía actualizada correctamente");
        } catch (\Throwable $th) {
            return $this->respond(500, null, $th->getMessage(), "Ocurrió un error inesperado");
        }
    }

    public function deleteCoordinadoraGuide($id)
    {
        try {
            $guide = $this::find($id);
            if (is_null($guide)) {
                return $this->respond(500, null, "Guide not found", "Guía no encontrada");
            }
            $guide->delete();
            return $this->respond(200, $guide, null, "Guía eliminada correctamente");
        } catch (\Throwable $th) {
            return $this->respond(500, null, $th->getMessage(), "Ocurrió un error inesperado");
        }
    }

    public function getAllGuideAndDetails($order_id)
    {
        try {
            $guideData = $this->with('getGuideDetails')
                        ->where('order_id', $order_id)
                        ->get();
            
            if (count($guideData) == 0) {
                return $this->respond(404, null, "guides not found", "No se encontraron guías");
            }

            return $this->respond(200, $guideData, null, "Guías obtenidas correctamente");
        } catch (\Throwable $th) {
            return $this->respond(500, null, $th->getMessage(), "Ocurrió un error inesperado");
        }
    }

    public function updateGuideStatus($order_id)
    {
        $Coordinadora = new Coordinadora;
        $guides = $this->getAllGuideAndDetails($order_id)['data'];
        $Coordinadora->authenticate();
        try {
            foreach ($guides as $guide) {
                $getStatusPetition = $Coordinadora->getGuideStatus($guide);
                if ($getStatusPetition['state'] != 200) {
                    return $this->respond(500, null, null, 'Ocurrió un fallo en el servicio: '.$getStatusPetition['message'].'');
                }
                $guideStatus = $getStatusPetition['data']['pedidos'][0]['estado_transporte'];
                $guide->update([
                    'status' => $guideStatus ?? null
                ]);
            }

            return $this->respond(200, null, null, "Guías actualizadas correctamente");
        } catch (\Throwable $th) {
            return $this->respond(600, null, $th->getMessage(), "Ocurrió un error inesperado");
        }
        

    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($group) {
            $group->getGuideDetails()->delete();
        });
    }
}
