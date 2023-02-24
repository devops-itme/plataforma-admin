<?php

namespace App\Modules\OrderModule\Controllers;

use App\Modules\GuideModule\Guide;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\OrderModule\CoordinadoraOrder;
use App\Modules\OrderModule\CoordinadoraOrderDetail;
use App\Modules\StatusMatrixModule\StatusMatrix;
use Illuminate\Validation\Rule;

trait CoordinadoraTrait
{
    use RestActions;

    
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
        "es_pago_contra_entrega",
        "es_entrega_mismo_dia",
        "valor_declarado",
        "order_id"
    ];
    
    public function validateGuide($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                "identificacion_destinatario" => 'nullable|numeric|max:999999999999999',
                "nombres_destinatario" => 'string',
                "apellidos_destinatario" => 'string',
                "direccion_destinatario" => 'required|string|min:10',
                "telefono_fijo_destinatario" => 'nullable|numeric',
                "telefono_celular_destinatario" => 'required|numeric',
                "codigo_ciudad_destinatario" => 'required|numeric|max:99999999',
                "nombre_ciudad_destinatario" => 'required|string',
                "codigo_pedido" => 'numeric',
                "numero_pedido" => 'numeric',
                "es_pago_contra_entrega" => 'string|size:1',
                "es_entrega_mismo_dia" => 'string|size:1',
                "valor_declarado" => 'numeric',
            ]
        );
    }

    public function validate($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                "referencia" => 'required|string',
                "unidades" => 'required|string',
                "peso" => 'required|string',
                "alto" => 'required|string',
                "ancho" => 'required|string',
                "largo" => 'required|string',
                "nombre_empaque" => 'required|string',
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
            $guide = CoordinadoraOrder::create([
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
                "fechahora_pedido" => null,
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

    public function createCoordinadoraGuideMassive($request)
    {
        $validate = $this->validateGuide($request);

        if ($validate->fails()) {
            return $this->respond(500, null, $validate->errors()->first(), "Error de validación");
        }

        try {
            $guide = CoordinadoraOrder::updateOrCreate([
                ['codigo_pedido' => $request->codigo_pedido],
                [   "order_id" => $request->order_id,
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
                    
                    "es_entrega_mismo_dia" => $request->entrega_mismo_dia,
                    "valor_declarado" => $request->valor_declarado,
                    "status" => null,
                    "state" => null
                ]
            ]);
            return $this->respond(201, $guide, null, "Guía creada exitósamente");
        } catch (\Throwable $th) {
            return $this->respond(500, null, $th->getMessage(), "Ocurrió un error inesperado");
        }
    }

    public function createProduct($request, $guide_id)
    {
        $validate = $this->validate($request);
        if ($validate->fails()) {
            return $this->respond(500, null, $validate->errors()->first(), "Ocurrió un error de validación");
        }

        try {
            $product = CoordinadoraOrderDetail::create([
                "guide_id" => $guide_id,
                "referencia" => $request->referencia,
                "unidades" => $request->unidades,
                "peso" => $request->peso,
                "alto" => $request->alto,
                "ancho" => $request->ancho,
                "largo" => $request->largo,
                "nombre_empaque" => $request->nombre_empaque,
            ]);
            return $this->respond(201, $product, null, "Producto creado exitósamente");
        } catch (\Throwable $th) {
            return $this->respond(500, null, $th->getMessage(), "Ocurrió un error inesperado");
        }
    }

}
