<?php

namespace App\Modules\ApiConnectionsModule\Models;

use App\Http\Controllers\Traits\RestActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Tealca
{
    use RestActions;

    protected $userName;
    protected $roleName;
    protected $token;

    public function login()
    {
        $loginResponse = Http::post(
            'http://qaapicore.tealca.com/Account/Login',
            [
                "login"  => "multi.entrega",
                "password" =>  "KIPWoMOoMAIpWz8MPYgUj2zZc6JUfvmCAM9HLPVw7/M"
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
        ])->get('http://qaapicore.tealca.com/v1/Destinations/' . $destination);

        if ($response->status() != 200) {
            return $this->respond(500, null, $response->json(), 'Fallo en el servicio');
        }

        return $this->respond(200, $response->json(), null, 'successful request');
    }

    public function requestCreateShipment($guide)
    {
        $body = [
            "UserLogin" => "multi.entrega",
            "Observations" => $guide->description,
            "TotalPieces" => $guide->pieces,
            "DeclaratedValueCurrency" => "USD",
            "IsSafeKeeping" => 0, //
            "DeclaratedValue" => $guide->declared,
            "CustomerCode" => "2722",
            "BUCodeSource" => "1102", //
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
            "ConsigneeTaxIdentTypeCode" => "V", //
            "ShipperCountry" => "VE", //
            "ShipperCity" => "CCS", //
            "ShipperAddress" => "Direccion Remitente", //
            "ShipperEmail" =>  $guide->email_contact,
            "ShippingMethodID" => 10, //
            "ShipperIdentification" => "3334441", //
            "ShipperName" => "Remitente API 1", //
            "ShipperPhoneCode" => "58", //
            "ShipperPhone" => "4141234567", //
            "ShipperTaxIdentTypeCode" => "V", //
            "DeliveryTypeID" => 10, //
            "MeasureUnitTypeID" => 30, //
            "WeightUnitID" => 10, //
            "PackageTypeID" => 20, //
            "ShipmentDetail" => array([
                "PieceNumber" =>  $guide->pieces,
                "PhysicalWeight" =>  $guide->kg
            ])
        ];

        $createShipmentResponse = Http::withHeaders([
            'Authorization' =>  $this->token,
        ])->post(
            'http://qaapicore.tealca.com/v1/Shipment/',
            $body
        );

        if ($createShipmentResponse->status() != 200) {
            return $this->respond(500, $body, $createShipmentResponse->json(), 'Fallo en el servicio. Guía N° ' . $guide->id);
        };

        $headers = $createShipmentResponse->headers();
        $external_id = explode(".", explode("'", $headers["Content-Disposition"][0])[2])[0];
        $guide->external_id = $external_id;
        $guide->save();
        return $this->respond(200, $guide, null, 'successful request');
    }
}
