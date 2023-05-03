<?php

namespace App\Modules\OrderModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\RestActions;
use App\Modules\ParameterValueModule\ParameterValue;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CoordinadoraOrderDetail extends Model
{
    use RestActions, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coordinadora_order_details';

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
        'referencia',
        'unidades',
        'peso',
        'alto',
        'ancho',
        'largo',
        'nombre_empaque',
        'guide_id',
        'state'
    ];

    public function validate($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                "referencia" => 'required|string',
                "unidades" => 'required|numeric',
                "peso" => 'required|numeric',
                "alto" => 'required|numeric',
                "ancho" => 'required|numeric',
                "largo" => 'required|numeric',
                "nombre_empaque" => [
                    'required',
                    'string',
                    Rule::in(['Bolsa', 'Caja']),
                ],
            ]
        );
    }

    public function createProduct(Request $request, $guide_id)
    {
        $validate = $this->validate($request);
        if ($validate->fails()) {
            return $this->respond(500, null, $validate->errors()->first(), "Ocurrió un error de validación");
        }

        try {
            $product = $this::create([
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

    public function getGuideProducts($guide_id)
    {
        try {
            $products = $this->where('guide_id', $guide_id)->get();
            if (is_null($products)) {
                return $this->respond(200, null, "products not found", "No se encontraron productos asociados");
            }
            return $this->respond(200, $products, null, "Producos encontrados");
        } catch (\Throwable $th) {
            return $this->respond(500, null, $th->getMessage(), "Ocurrió un error inesperado");
        }
    }

    public function updateProduct(Request $request, $id)
    {
        $validate = $this->validate($request);
        if ($validate->fails()) {
            return $this->respond(500, null, $validate->errors()->first(), "Ocurrió un error de vaidación");
        }

        try {
            $product = $this::find($id);
            if (is_null($product)) {
                return $this->respond(404, null, "product not found", "No se encontró información del producto");
            }

            $product->update([
                "referencia" => $request->referencia ?? $product->referencia,
                "unidades" => $request->unidades ?? $product->unidades,
                "peso" => $request->peso ?? $product->peso,
                "alto" => $request->alto ?? $product->alto,
                "ancho" => $request->ancho ?? $product->ancho,
                "largo" => $request->largo ?? $product->largo,
                "nombre_empaque" => $request->nombre_empaque ?? $product->nombre_empaque,
            ]);

            return $this->respond(200, $product, null, "Producto actualizado exitósamente");
        } catch (\Throwable $th) {
            return $this->respond(500, null, $th->getMessage(), "Ocurrió un error inesperado");
        }
    }
    public function deleteProduct($id)
    {
        try {
            $product = $this::find($id);
            if (is_null($product)) {
                return $this->respond(500, null, "product not found", "Producto no encontrado");
            }
            $product->delete();
            return $this->respond(200, $product, null, "Producto eliminado correctamente");
        } catch (\Throwable $th) {
            return $this->respond(500, null, $th->getMessage(), "Ocurrió un error inesperado");
        }
    }
}
