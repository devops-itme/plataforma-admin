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
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ShipmentTealcaImport implements ToCollection, WithHeadingRow, WithValidation
{
    use OrderTrait, GuideTrait;
    public function collection(Collection $rows)
    {
        $order_type = ParameterValue::where('name', 'International')->first(['id'])->id;
        $order = Order::where('order_type', $order_type)->latest()->first(['id', 'order_number']);
        $lot_number = 'Lote_1';
        if (!is_null($order)) {
            $last_batch = explode('_', $order->order_number)[1];
            $lot_number = 'Lote_' . ($last_batch + 1);
        }

        DB::beginTransaction();
        $orderResponse = $this->storeOrder(new Request(array(
            'user_id' => Auth::user()->id,
            'order_number' => $lot_number,
            'order_type' => $order_type,
            'creator_user_id' => Auth::user()->id,
        )));
        if ($orderResponse['state'] != 200) {
            return 0;
        };
        $order_id = $orderResponse['data']['id'];
        foreach ($rows as $row) {
            $guideResponse = $this->storeGuide(new Request(array(
                'order_id' => $order_id,
                'description' => $row['observ'],
                'address_name' => $row['dirdes'],
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
            if ($guideResponse['state'] != 200) {
                return DB::rollBack();
            };
        }
        DB::commit();
    }

    public function rules(): array
    {
        return [
            "paisdes" => 'required|string|size:3', //
            "ciudes" => 'required|string|size:3', //
            "nomdes" => 'required|string', //
            "dirdes" => 'required|string|max:200', //
            "documenttypedes" => 'required|string', //
            "documentnumberdes" => 'required|numeric', //
            "teldes" => 'required|numeric', //
            "email" => 'required|email', //
            "oficinadeentrega" => 'required|string', //
            "preguia" => 'required|numeric', //
            "numfactura" => 'required|alpha_num', //
            "declarado" => 'required|numeric', //
            "piezas" => 'required|numeric', //
            "kilos" => 'required|numeric', //
            "namecontact" => 'required|string', //
            "observ" => 'nullable', //
        ];
    }
}
