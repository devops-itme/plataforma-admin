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

class ShipmentCoordinadoraImport implements ToCollection, WithHeadingRow
{
    use OrderTrait;
    
    /* protected $CoordinadoraOrder;
    protected $CoordinadoraOrderDetail; */
    protected $country;
    protected $user_id;
    protected $guide_id;
    

    public function __construct($user_id, $country)
    {
        $this->user_id = $user_id;
        $this->country = $country;
    }

     

    /* public function validateCitiesDestination($rows){
        
        $Tealca = new Tealca();
        $Tealca->login();
        
        $Tealca->getDestination();
        $destinationCodes = $Tealca->getDestination()['data'];
        
        $arrayCodes = [];

        foreach ($destinationCodes as $code) {
            array_push($arrayCodes, $code['destinationCode']);
        }
        $cellNumber = 0;

        foreach ($rows as $row) {
            $response = in_array($row['ciudes'], $arrayCodes);
            ++$cellNumber;
            if ($response == false) {
                $cellNumber = $cellNumber + 1;
                $this->wrongRow = $cellNumber;
                return $this->respond(500, null, null, 'En la fila: '.$cellNumber.' la ciudad es errónea');
            }
        }
        return $this->respond(200, null, null, 'Importación exitosa');
    } */

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

        //DB::beginTransaction();
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
            )));
            //dd($guideResponse);
            $orderDetailResponse =$CoordinadoraOrderDetail->createProduct(new Request(array(
                "referencia" => $row['referencia'],
                "unidades" => $row['unidades'],
                "peso" => $row['peso'],
                "alto" => $row['alto'],
                "ancho" => $row['ancho'],
                "largo" => $row['largo'],
                "nombre_paquete" => $row['nombre_paquete'],
            )), $guideResponse['data']['id']);
            
            /* if ($guideResponse['state'] == 500) {
                DB::rollBack();
                throw ValidationException::withMessages([$guideResponse['message']]);
            }; */
        }
        DB::commit();
    }

}
