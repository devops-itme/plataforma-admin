<?php

namespace App\Modules\ApiConnectionsModule\Models;

use App\Http\Controllers\Traits\RestActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Modules\ApiConnectionsModule\Models\ApiSync;
use Illuminate\Http\Client\RequestException;

class Tealca
{
    use RestActions;

    protected $userName;
    protected $roleName;
    protected $token;

    public function login()
    {
        $loginResponse = Http::post(
            env("TEALCA_URL") . 'Account/Login',
            [
                "login"  => env("TEALCA_USER"),
                "password" =>  env("TEALCA_PASSWORD")
            ]
        );
        if ($loginResponse->status() != 200) {
            return $this->respond(500, null, $loginResponse->json(), 'Fallo en el servicio');
        }
        $this->userName = $loginResponse->json()['userName'];
        $this->roleName = $loginResponse->json()['roleName'];
        $this->token = 'Bearer ' .  $loginResponse->json()['token'];

        return $this->respond(200, $loginResponse->json(), null, 'successful login');
    }

    public function requestDestination($destination = '')
    {
        $response = Http::withHeaders([
            'Authorization' =>  $this->token,
        ])->get(env("TEALCA_URL") . 'v1/Destinations/' . $destination);

        if ($response->status() != 200) {
            return $this->respond(500, null, $response->json(), 'Fallo en el servicio');
        }

        return $this->respond(200, $response->json(), null, 'successful request');
    }

    public function requestCreateShipment($guide)
    {   
        $ApiSync = new ApiSync;
        $userData = auth()->user();
        $weight = $guide->kg;
        $weight = floatval(str_replace(",",".",$weight));
        
        $body = [
            "UserLogin" => env("TEALCA_USER"),
            "PickingNumber" => $guide->pre_guide,
            "Observations" => $guide->description,
            "TotalPieces" => (int)$guide->pieces,
            "DeclaratedValueCurrency" => "USD",
            "IsSafeKeeping" => 0,
            "DeclaratedValue" => (int)$guide->declared,
            "CustomerCode" => "2722",
            "BUCodeSource" => "NN",
            // "ConsigneeCountry" =>  $guide->country,
            "ConsigneeCountry" =>  'VE',
            "ConsigneeCity" =>  $guide->city,
            "ConsigneeAddress" =>  $guide->address_name,
            "ConsigneePhoneCode" => "58",
            "ConsigneePhone" =>  $guide->phone_contact,
            "EmailType" => "020",
            "ConsigneeEmail" =>  $guide->email_contact,
            "ConsigneeName" =>  $guide->recipient_name,
            "ConsigneeIdentification" =>  $guide->document,
            "ConsigneeTaxIdentTypeCode" => "V",
            "ShipperCountry" => "VE",
            "ShipperCity" => "CCS",
            "ShipperAddress" => "Direccion Remitente",
            "ShipperEmail" =>  $guide->email_contact,
            "ShippingMethodID" => 10,
            "ShipperIdentification" => "3334441",
            "ShipperName" => "Remitente API 1",
            "ShipperPhoneCode" => "58",
            "ShipperPhone" => "4141234567",
            "ShipperTaxIdentTypeCode" => "V",
            "DeliveryTypeID" => 10,
            "MeasureUnitTypeID" => 30,
            "WeightUnitID" => 10,
            "PackageTypeID" => 20,
            "ShipmentDetail" => array([
                "PieceNumber" =>  (int)$guide->pieces,
                "PhysicalWeight" =>  $weight
            ])
        ];

        return $this->respond(500, $body, 'error error', 'Fallo en el servicio. Guía N°');
        
        $createShipmentResponse = Http::withHeaders([
            'Authorization' =>  $this->token,
        ])->post(
            env("TEALCA_URL") . 'v1/Shipment/',
            $body
        );

        
        
        if ($createShipmentResponse->status() != 200) {
            //dd($createShipmentResponse->json()['error'][0]);
            $ApiSync->ApiSaveLog(
                "Multientrega_Admin",
                array(
                    'origin_user' => $userData->email ?? null
                ),
                "Tealca_Api",
                array(
                    'destination_url' => env("TEALCA_URL") . 'v1/Shipment/',
                    'destination_action' => "generate_guide_number"
                ),
                array(
                    'guide_data' => $body
                ),
                array(
                    'response' => "failed_service",
                    'response_error' => $createShipmentResponse->json()['error'],
                    'response_status' => $createShipmentResponse->status(),
                    'failed_guide_id' => $guide->id,
                ),
                "LOST"
            );
            return $this->respond(500, $body, $createShipmentResponse->json(), 'Fallo en el servicio. Guía N° ' . $guide->id);
        };

        $headers = $createShipmentResponse->headers();
        $external_id = explode(".", explode("'", $headers["Content-Disposition"][0])[2])[0];
        $guide->external_id = $external_id;
        $guide->save();

        $ApiSync->ApiSaveLog(
            "Multientrega_Admin",
            array(
                'origin_user' => $userData->email ?? null
            ),
            "Tealca_Api",
            array(
                'destination_url' => env("TEALCA_URL") . 'v1/Shipment/',
                'destination_action' => "generate_guide_number"
            ),
            array(
                'guide_data' => $body
            ),
            array(
                'response' => "guide_generated",
                'guide_id' => $guide->id,
                'guide_number' => substr($guide->external_id, 1)
            ),
            "ACK"
        );
        
        return $this->respond(200, $guide, null, 'successful request');
    }

    public function requestOrderStatus($guide)
    {
        try {
            $trackingResponse = Http::withHeaders([
                'Authorization' =>  $this->token,
            ])->get(
                env("TEALCA_URL") . 'Tracking?shipment=' . $guide
            );
    
            if ($trackingResponse->status() != 200 || empty($trackingResponse)) {
                return $this->respond(500, null, $trackingResponse, 'Fallo en el servicio. Guía N° ' . $guide);
            };
    
    
            return $this->respond(200, $trackingResponse->json(), null, 'successful request');
        } catch (\Throwable $th) {
            return $this->respond(500, null, null, 'Error');
        }
        
    }

    public function getDestination()
    {
        $destination = Http::withHeaders([
            'Authorization' =>  $this->token,
        ])->get(
            env("TEALCA_URL") . 'v1/Destinations'
        );

        if ($destination->status() != 200) {
            return $this->respond(500, null, $destination, 'Fallo en el servicio. Guía N° ');
        };


        return $this->respond(200, $destination->json(), null, 'successful request');
    }

    public function getTiendas()
    {
        $tiendas = Http::withHeaders([
            'Authorization' =>  $this->token,
        ])->get(
            env("TEALCA_URL") . 'BusinessUnit?Status=1'
        );

        if ($tiendas->status() != 200) {
            return $this->respond(500, null, $tiendas, 'Fallo en el servicio. Guía N° ');
        };


        return $this->respond(200, $tiendas->json(), null, 'successful request');
    }
}
