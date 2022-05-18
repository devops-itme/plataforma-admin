<?php

namespace App\Modules\ApiConnectionsModule\Models;

use App\Http\Controllers\Traits\RestActions;
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
        $createShipment = Http::post(
            'http://qaapicore.tealca.com/v1/Shipment/',
            [
                "UserLogin" => "multi.entrega",
                "Observations" => $guide->description,
                "TotalPieces" => $guide->pieces,
                "DeclaratedValueCurrency" => "USD",
                "IsSafeKeeping" => 0, //
                "DeclaratedValue" => $guide->declared,
                "CustomerCode" => "2722",
                "BUCodeSource" => "1102", //
                "ConsigneeCountry" =>  $guide->country,
                "ConsigneeCity" =>  $guide->city,
                "ConsigneeAddress" =>  $guide->address_name,
                "ConsigneePhoneCode" => "58",
                "ConsigneePhone" =>  $guide->phone_contact,
                "EmailType" => "020",
                "ConsigneeEmail" =>  $guide->email_contact,
                "ConsigneeName" =>  $guide->recipient_name,
                "ConsigneeIdentification" =>  $guide->recipient_name,
                "ConsigneeTaxIdentTypeCode" => "V", //
                "ShipperCountry" => "PAN", //
                "ShipperCity" => "CCS", //
                "ShipperAddress" => "Direccion Remitente", //
                
                "WeightUnitID" => 10,
            ]
        );
    }
}
