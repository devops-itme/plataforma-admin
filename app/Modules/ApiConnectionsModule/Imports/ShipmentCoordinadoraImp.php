<?php

namespace App\Modules\ApiConnectionsModule\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Modules\OrderModule\Controllers\OrderTrait;
use App\Modules\OrderModule\Order;
use App\Modules\ParameterValueModule\ParameterValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Modules\OrderModule\CoordinadoraOrder;
use App\Modules\OrderModule\CoordinadoraOrderDetail;

class ShipmentCoordinadoraImp implements ToModel, WithHeadingRow
{   
    use OrderTrait;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $country;
    protected $user_id;
    

    public function __construct($user_id, $country)
    {
        $this->user_id = $user_id;
        $this->country = $country;
    }

    public function model(array $row)
    {   
        $order_type = ParameterValue::where('name', 'International')->first(['id'])->id;
        
        if ($this->country == "Colombia") {
            $order = Order::where('order_type', $order_type)->where('description', $this->country)
            ->latest()->first(['id', 'order_number']);
            $lot_number = 'Col_1';
            
            if (!is_null($order)) {
                $last_batch = explode('_', $order->order_number)[1];
                $lot_number = 'Col_' . ($last_batch + 1);
            }
        }

        if ($this->country == "Venezuela") {
            $order = Order::where('order_type', $order_type)
            ->where('description', $this->country)
            ->latest()->first(['id', 'order_number']);
            
            $lot_number = 'Ven_1';

            if (!is_null($order)) {
                $last_batch = explode('_', $order->order_number)[1];
                $lot_number = 'Ven_' . ($last_batch + 1);
            }
        }
        
        //dd($lot_number);

        DB::beginTransaction();
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
        //dd($order_id);
        /* $order = CoordinadoraOrder::create([
            
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
            "codigo_tienda" => "1",
            "es_entrega_mismo_dia" => $row['es_entrega_mismo_dia'],
            "valor_declarado" => $row['valor_declarado']
        ]); */
        return new CoordinadoraOrder([
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
            "codigo_tienda" => "1",
            "es_entrega_mismo_dia" => $row['es_entrega_mismo_dia'],
            "valor_declarado" => $row['valor_declarado'],
            "state" => null,
            "status" => null,
        ]);
    }
}
