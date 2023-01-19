<?php

namespace App\Modules\ApiConnectionsModule\Models;

use App\Http\Controllers\Traits\RestActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiSync
{   
    use RestActions;

    public function ApiSaveLog(
        $origin = '', // plataforma, url, ip
        $origin_detail = [], // usuario, tabla, json
        $destination = '', //url, ip, nombre de BD
        $destination_detail = [], //json, accion, tabla de destino, etc
        $payload = [], //json, sql
        $response = [], //respuesta
        $transaction_state = '' //ACK = recibido, ACK_PENDING = pendiente, LOST = perdido
    )
    {   
        
        Http::post(
            env("SYNCAPI_URL"). 'log/create',
            [   
                'origin' => $origin,
                'origin_detail' => $origin_detail,
                'destination' => $destination,
                'destination_detail' => $destination_detail,
                'payload' => $payload,
                'response' => $response,
                'transaction_state' => $transaction_state
            ]
        );
    }

    public function apiGetLogs(){
        $logs = Http::get( env("SYNCAPI_URL"). 'log/get-all' );

        if ($logs->status() != 200) {
            return $this->respond(500, null, null, "Ocurrió un fallo en el servicio");
        }
        
        return $this->respond(500, $logs->json(), null, "Logs obtenidos correctamente");
    }
}