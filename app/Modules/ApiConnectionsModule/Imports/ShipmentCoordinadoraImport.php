<?php

namespace App\Modules\ApiConnectionsModule\Imports;

use App\Modules\OrderModule\Controllers\OrderTrait;
use App\Modules\OrderModule\Order;
use App\Modules\ParameterValueModule\ParameterValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
//use App\Modules\OrderModule\Controllers\CoordinadoraTrait;
use Illuminate\Support\Facades\Validator;
use App\Modules\OrderModule\CoordinadoraOrder;
use App\Modules\OrderModule\CoordinadoraOrderDetail;
use App\Modules\OrderModule\CoordinadoraCities;

class ShipmentCoordinadoraImport implements ToCollection, WithHeadingRow, WithValidation
{
    use OrderTrait;
    
    /* protected $CoordinadoraOrder;
    protected $CoordinadoraOrderDetail; */
    protected $country;
    protected $user_id;
    protected $guide_id;
    protected $wrongRow;
    

    public function __construct($user_id, $country)
    {
        $this->user_id = $user_id;
        $this->country = $country;
    }

    public function validateCityCode($rows)
    {

        $cellNumber = 0;

        foreach ($rows as $row) {
            if (strlen($row['codigo_ciudad_destinatario']) == 7) {
                $row['codigo_ciudad_destinatario'] = '0'.$row['codigo_ciudad_destinatario'];
            }
            $validateCity = CoordinadoraCities::where('codigo_ciudad', $row['codigo_ciudad_destinatario'])->first();
            ++$cellNumber;
            if (is_null($validateCity)) {
                $cellNumber = $cellNumber + 1;
                $this->wrongRow = $cellNumber;
                return $this->respond(500, null, null, 'En la fila: '.$cellNumber.' el código de la ciudad indicado no existe. Por favor revise e intente nuevamente.');
            }
        }
        return $this->respond(200, null, null, 'Códigos validados correctamente');
    }

    public function collection(Collection $rows)
    {   
        
        $order_type = ParameterValue::where('name', 'International')->first(['id'])->id;
        
        if ($this->country == "Colombia") {
            $order = Order::where('order_type', $order_type)
            ->where('description', 'LIKE',  "Colombia")
            ->latest()->first(['id', 'order_number']);
            
            $lot_number = 'Col_1';
            
            if (!is_null($order)) {
                $last_batch = explode('_', $order->order_number)[1];
                $lot_number = 'Col_' . ($last_batch + 1);
            }
            
        }

        if ($this->country == "Venezuela") {
            $order = Order::where('order_type', $order_type)
            ->where('description', 'LIKE' ,"Venezuela")
            ->latest()->first(['id', 'order_number']);
            $lot_number = 'Ven_1';

            if (!is_null($order)) {
                $last_batch = explode('_', $order->order_number)[1];
                $lot_number = 'Ven_' . ($last_batch + 1);
            }
        }
        
        //dd($lot_number);

        DB::beginTransaction();
        $validateCities = $this->validateCityCode($rows);
        if ($validateCities['state'] == 500) {
            DB::rollBack();
            return null;
        }

        $orderResponse = $this->storeOrder(new Request(array(
            // 'user_id' => Auth::user()->id,
            'user_id' => $this->user_id,
            'order_number' => $lot_number,
            'order_type' => $order_type,
            'creator_user_id' => Auth::user()->id,
            'description' => $this->country
        )));
        //dd($orderResponse);
        if ($orderResponse['state'] != 200) {
            return 0;
        };
        $order_id = $orderResponse['data']['id'];
        
        $CoordinadoraOrder = new CoordinadoraOrder();
        $CoordinadoraOrderDetail = new CoordinadoraOrderDetail();
        
        foreach ($rows as $row) {
            if (strlen($row['codigo_ciudad_destinatario']) == 7) {
                $row['codigo_ciudad_destinatario'] = '0'.$row['codigo_ciudad_destinatario'];
            }
            $guideResponse = $CoordinadoraOrder->createCoordinadoraGuideMassive(new Request(array(
                "order_id" => $order_id,
                "identificacion_destinatario" => $row['identificacion_destinatario'],
                "nombres_destinatario" => $row['nombres_destinatario'],
                "apellidos_destinatario" => $row['apellidos_destinatario'],
                "direccion_destinatario" => $row['direccion_destinatario'],
                "telefono_fijo_destinatario" => $row['telefono_fijo_destinatario'],
                "telefono_celular_destinatario" => $row['telefono_celular_destinatario'],
                "codigo_ciudad_destinatario" => $row['codigo_ciudad_destinatario'],
                "nombre_ciudad_destinatario" => $row['nombre_ciudad_destinatario'],
                "codigo_pedido" => $row['codigo_pedido'],
                "numero_pedido" => $row['numero_pedido'],
                "es_entrega_mismo_dia" => $row['es_entrega_mismo_dia'],
                "valor_declarado" => (double)$row['valor_declarado']
            )), $lot_number);
            //dd($guideResponse);
            $orderDetailResponse = $CoordinadoraOrderDetail->createProduct(new Request(array(
                "referencia" => $row['referencia'],
                "unidades" => $row['unidades'],
                "peso" => $row['peso'],
                "alto" => $row['alto'],
                "ancho" => $row['ancho'],
                "largo" => $row['largo'],
                "nombre_empaque" => $row['nombre_empaque'],
            )), $guideResponse['data']['id']);
            //dd($orderDetailResponse);
            if ($guideResponse['state'] != 201 || $orderDetailResponse['state'] != 201) {
                DB::rollBack();
                throw ValidationException::withMessages([$guideResponse['message']]);
            };
        }
        DB::commit();
    }

    public function getWrongRow(){
        return $this->wrongRow;
    }

    public function rules(): array
    {
        return [
            "identificacion_destinatario" => 'required|numeric|digits_between:1,15',
            "nombres_destinatario" => 'required|string|max:100',
            "apellidos_destinatario" => 'required|string|max:100',
            "direccion_destinatario" => 'required|string|min:10|max:500',
            "telefono_fijo_destinatario" => 'required|numeric|digits_between:10,20',
            "telefono_celular_destinatario" => 'required|numeric|digits_between:10,20',
            "codigo_ciudad_destinatario" => 'required|numeric|digits_between:7,8',
            "nombre_ciudad_destinatario" => 'required|string|max:100',
            "codigo_pedido" => 'required|numeric',
            "numero_pedido" => 'required|numeric',
            "es_entrega_mismo_dia" => 'required|string|size:1',
            "valor_declarado" => 'required|numeric',

            "referencia" => 'required|string|max:50',
            "unidades" => 'required|numeric',
            "peso" => 'required|numeric',
            "alto" => 'required|numeric',
            "ancho" => 'required|numeric',
            "largo" => 'required|numeric',
            "nombre_empaque" => 'required|string|max:500',
        ];
    }

    public function customValidationMessages()
{
    return [
        'codigo_ciudad_destinatario.digits_between' => 'El código de la ciudad debe tener 8 dígitos, salvo si el dígito inicial es cero (0), en cuyo caso debe tener 7.',
        'es_entrega_mismo_dia.size' => 'el campo es_entrega_mismo_dia solo puede contener S o N (Si / No)',
    ];
}

}
