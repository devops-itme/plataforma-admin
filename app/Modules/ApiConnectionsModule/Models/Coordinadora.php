<?php

namespace App\Modules\ApiConnectionsModule\Models;

use App\Http\Controllers\Traits\RestActions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;
use Soapclient;
use App\Modules\OrderModule\CoordinadoraOrder;
use App\Modules\ApiConnectionsModule\Models\ApiSync;


class Coordinadora
{   
    use RestActions;
    
   /*  protected $user;
    protected $password;
    protected $id_client; */
    protected $apiKey;
   /*  protected $apiPassword; */
    protected $nit;
    /* protected $urlDev; */
    protected $token;

    public function __construct()
    {   
        
        //$this->user = "investcapital.ws";
        //$this->id_client = 39327;
        //$this->password = "9b9be4aca68315b70bc9d7ac6e2bbe013e406a891b311dd50f6770ab73d153d9";

        //$this->apiKey = "f923a1b2-03b0-11ed-b939-0242ac120002";
        //$this->apiPassword = "lY1kT6rE3kJ8hU9i";|
        $this->nit = "901090679";
        
        //$this->urlDev = 'https://apis-dev.coordiutil.com/fullfilment/';
    }

    public function authenticate()
    {
        $authenticate = Http::post(
            env("COORD_URL") . 'clientes/autenticar',
            [
                "usuario" => env("COORD_USER"),
                "clave" => env("COORD_PASS")
            ]
        );
        
        if ($authenticate->json()['isError'] == 1) {
            return $this->respond(500, null, $authenticate->json(), 'Fallo en el servicio');
        }
        
        //return $authenticate->json()['isError'];
        $this->token = $authenticate->json()['token'];
        return $this->respond(200, 'token: '.$this->token.'', null, 'successful login');
    }

    public function validate(Request $request)
    {
        
    }

    public function generateGuide($request)
    {   
        $body = [
            "identificacion_cliente" => (string) $request->identificacion_destinatario,
            "nombres_cliente"=> $request->nombres_destinatario,
            "apellidos_cliente"=> $request->apellidos_destinatario,
            "direccion_cliente"=> $request->direccion_destinatario,
            "telefono_fijo_cliente"=> (string) $request->telefono_fijo_destinatario,
            "codigo_ciudad_cliente"=> (string) $request->codigo_ciudad_destinatario,

            "identificacion_destinatario"=> (string) $request->identificacion_destinatario,
            "nombres_destinatario"=> $request->nombres_destinatario,
            "apellidos_destinatario"=> $request->apellidos_destinatario,
            "direccion_destinatario"=> $request->direccion_destinatario,
            "telefono_fijo_destinatario"=> (string) $request->telefono_fijo_destinatario,
            "telefono_celular_destinatario"=> (string) $request->telefono_celular_destinatario,
            "codigo_ciudad_destinatario"=> (string) $request->codigo_ciudad_destinatario,
            "nombre_ciudad_destinatario"=> $request->nombre_ciudad_destinatario,

            "codigo_pedido"=> (string) $request->codigo_pedido,
            "numero_pedido"=> (string) $request->numero_pedido,
            "fechahora_pedido"=> $request->created_at,
            "codigo_tienda"=> "1",
            "codigo_vendedor"=> "0",
            "es_pago_contra_entrega"=> "N",
            "es_entrega_mismo_dia"=> $request->es_entrega_mismo_dia,
            "total_coniva"=> $request->valor_declarado,
            "valor_declarado"=> $request->valor_declarado,
            "total_iva"=> $request->valor_declarado,
            "nit_remitente"=> $request->nit_remitente,
            "nombre_remitente"=> $request->nombre_remitente,
            "telefono_remitente"=> $request->telefono_remitente,
            "detalle"=> $request->getGuideDetails
        ];

        
        $generateOrderPetition = Http::withHeaders([
            'Authorization' =>  'Bearer '.$this->token.'',
        ])->post(
            env("COORD_URL") . 'pedidos/guardar',
            $body
        );

        if ($generateOrderPetition->json()['mensaje'] != "ok") {
            return $this->respond(500, null, $generateOrderPetition->json()['mensaje'], "Hubo un fallo en el servicio");
        }

        $request->state = 1;
        $request->fechahora_pedido = now();
        $request->save();
        /* $findGuide = CoordinadoraOrder::find($request->id)->first();
        $findGuide->update([
            'state' => 1
        ]); */
        //dd($generateOrderPetition->json()['mensaje']);
        return $this->respond(200, $generateOrderPetition->json(), null, "Guías generadas exitósamente");
    }

   
}