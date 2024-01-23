<?php

namespace App\Modules\ApiConnectionsModule\Imports;

use App\Modules\GuideModule\Controllers\GuideTrait;
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
use App\Modules\ApiConnectionsModule\Models\Tealca;
use Illuminate\Support\Facades\Validator;
use Log;

class ShipmentTealcaImport implements ToCollection, WithHeadingRow, WithValidation
{
    use OrderTrait, GuideTrait;

    protected $unique_phone;
    protected $wrongRow;
    private $rows = 0;
    

    public function __construct(bool $unique_phone = false,$user_id)
    {
        $this->user_id = $user_id;
        $this->unique_phone = $unique_phone;
    }

    protected function validatePhones($rows)
    {
        $phones = [];
        $messages = [];
        $failed_validation = false;
        foreach ($rows as $key => $row) {
            if (in_array($row['teldes'], $phones)) {
                $failed_validation = true;
                $messages[] = 'Hubo un error en la fila  ' . ($key + 1) . '. El campo teldes(Teléfono de destino) se encuentra repetido.';
            }
            if (count($rows) == ($key + 1) && $failed_validation) {
                throw ValidationException::withMessages($messages);
            }
            $phones[] = $row['teldes'];
        }
    }

    protected function validateNamesContact($rows)
    {
        $user = [];
        $names = ['IRVING ALVARADO',
                  'DANIEL BARKER',
                  'ORLANDO MONTENEGRO',
                  'LUISA ARCHIBOLD BURTO',
                  'JULIÁN AYALA',
                  'FRANCISCO DIAZ',
                  'LUIS MINA',
                  'CIRILO ABDIEL MCFARLANE VILLA',
                  'REINIER LICONA',
                  'DEREX VARGAS',
                  'RYAN AYALA',
                  'GELEN YAJAIRY SANCHEZ ALVAREZ',
                  'MIGUEL A.DAVIS',
                  'BRAYAN DEL VICEHIO',
                  'ROGELIO RODRÍGUEZ',
                  'MELANY YANIN MXWELL',
                  'RICARDO REYNA',
                  'MARVIN REYNA'
        ];
        $messages = [];
        $failed_validation = false;
        foreach ($rows as $key => $row) {
            if (in_array($row['namecontact'] ,$names)) {
                foreach ($names as $black_list) {
                    if (($row['namecontact'] == $black_list)) {
                        $failed_validation = true;
                    }
                }
                $messages[] = 'Verifique la fila  ' . ($key + 1) . ' porque el nombre del contacto se encuentra en lista negra';
            }
            if (count($rows) == ($key + 1) && $failed_validation) {
                throw ValidationException::withMessages($messages);
            }
            $user[] = $row['namecontact'];
        }
    }

    protected function validateNamesDestination($rows)
    {
        $user = [];
        $names = ['IRVING ALVARADO',
                  'DANIEL BARKER',
                  'ORLANDO MONTENEGRO',
                  'LUISA ARCHIBOLD BURTO',
                  'JULIÁN AYALA',
                  'FRANCISCO DIAZ',
                  'LUIS MINA',
                  'CIRILO ABDIEL MCFARLANE VILLA',
                  'REINIER LICONA',
                  'DEREX VARGAS',
                  'RYAN AYALA',
                  'GELEN YAJAIRY SANCHEZ ALVAREZ',
                  'MIGUEL A.DAVIS',
                  'BRAYAN DEL VICEHIO',
                  'ROGELIO RODRÍGUEZ',
                  'MELANY YANIN MXWELL',
                  'RICARDO REYNA',
                  'MARVIN REYNA'
        ];
        $messages = [];
        $failed_validation = false;
        foreach ($rows as $key => $row) {
            if (in_array($row['nomdes'] ,$names)) {
                foreach ($names as $black_list) {
                    if (($row['nomdes'] == $black_list)) {
                        $failed_validation = true;
                    }
                }
                $messages[] = 'Verifique la fila  ' . ($key + 1) . ' porque el nombre del destinatario se encuentra en lista negra';
            }
            if (count($rows) == ($key + 1) && $failed_validation) {
                throw ValidationException::withMessages($messages);
            }
            $user[] = $row['nomdes'];
        }
    }

    public function validateCitiesDestination($rows){
        
        try {
            $Tealca = new Tealca();
            $Tealca->login();
            
            $Tealca->getDestination();
            $destinationCodes = $Tealca->getDestination()['data'];
            Log::info("entró destinationCodes: " . json_encode($destinationCodes));
            
            $arrayCodes = [];
            if (count($destinationCodes) >= 1) {
                foreach ($destinationCodes as $code) {
                    array_push($arrayCodes, $code['destinationCode']);
                }
                Log::info("lleno array: " . json_encode($arrayCodes));
            } 
            $cellNumber = 0;
            Log::info("codes: " . json_encode($arrayCodes));
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
        } catch (\Throwable $th) {
            return $this->respond(500, null, $th->getMessage(), 'Ocurrió un error inesperado');
        }
    }

    public function collection(Collection $rows)
    {   
        
        $order_type = ParameterValue::where('name', 'International')->first(['id'])->id;
        $order = Order::where('order_type', $order_type)
        ->where('order_number', 'like', '%Lote%')
        ->latest()->first(['id', 'order_number']);
        
        $lot_number = 'Lote_1';
        if (!is_null($order)) {
            $last_batch = explode('_', $order->order_number)[1];
            $lot_number = 'Lote_' . ($last_batch + 1);
        }
        
        DB::beginTransaction();
        $orderResponse = $this->storeOrder(new Request(array(
            // 'user_id' => Auth::user()->id,
            'user_id' => $this->user_id,
            'order_number' => $lot_number,
            'order_type' => $order_type,
            'creator_user_id' => Auth::user()->id,
        )));
        Log::info("order: " . json_encode($orderResponse));
        if ($orderResponse['state'] != 200) {
            return 0;
        };
        $order_id = $orderResponse['data']['id'];
        Log::info("paso Order_id: " . $order_id);
        if (!$this->unique_phone) {
            $this->validatePhones($rows);
        }
            $this->validateNamesDestination($rows);
            Log::info("paso validateNames");
            $this->validateNamesContact($rows);
            Log::info("paso validateNamesContact");
        $validateCities = $this->validateCitiesDestination($rows);
        if ($validateCities['state'] == 500) {
            DB::rollBack();
            return null;
            Log::info("Entro a validatorCities " . json_encode($validateCities));
        }
        Log::info("Paso validatorCities: " . json_encode($validateCities));

        foreach ($rows as $row) {
            Log::info("entró a foreach");
            $guideResponse = $this->storeGuide(new Request(array(
                'order_id' => $order_id,
                'description' => $row['observ'] ?? null,
                'address_name' => trim($row['dirdes']),
                'country' => $row['paisdes'],
                'city' => $row['ciudes'],
                'recipient_name' => $row['nomdes'],
                'document_type' => $row['documenttypedes'],
                'document' => $row['documentnumberdes'],
                'delivery_office' => $row['oficinadeentrega'],
                'pre_guide' => $row['preguia'],
                'invoice_number' => $row['numfactura'],
                'declared' => $row['declarado'],
                'pieces' => $row['piezas'],
                'kg' => $row['kilos'],
                'contact' => $row['namecontact'],
                'phone_contact' => $row['teldes'],
                'email_contact' => $row['email'],
            )));
            Log::info("pasó foreach");
            Log::info("guiaResponse: " . json_encode($guideResponse));
            if ($guideResponse['state'] != 200) {
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
            "paisdes" => 'required|string|size:3',
            "ciudes" => 'required|string|size:3',
            "nomdes" => 'required|string',
            "dirdes" => 'required|string|max:200',
            "documenttypedes" => 'required|string',
            "documentnumberdes" => 'required|numeric',
            "teldes" => 'required|numeric|max:99999999999',
            "email" => 'required|email',
            "oficinadeentrega" => 'required|string',
            "preguia" => 'required|numeric',
            "numfactura" => 'required|alpha_num',
            "declarado" => 'required|numeric',
            "piezas" => 'required|numeric',
            "kilos" => 'required|numeric',
            "namecontact" => 'required|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'teldes.max' => 'El teléfono no puede exceder los 11 dígitos',
            
        ];
    }

}
