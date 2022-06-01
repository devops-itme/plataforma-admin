<?php

namespace App\Modules\OrderModule\Exports;

use App\Modules\OrderModule\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Modules\GuideModule\Guide;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */


    public function headings(): array
    {
        return [
           

            __('#'),
            __('numGuia'),
            __('guiaMe'),
            __('FechaCreacion'),
            __('Origen'),
            __('codCustomer'),
            __('nomDes'),
            __('documentTypeDes'),
            __('documentNumberDes'),
            __('email'),
            __('dirDes'),
            __('ciuDes'),
            __('telDes'),
            __('paisDes'),
            __('piezas'),
            __('kilos'),
            __('declarado'),
            __('numFactura'),
            __('preGuia'),
            __('nameContact'),
            __('observ'),
            __('usuario'),
            __('oficinaDeEntrega'),
            __('status'),
            __('fechaStatus'),

        ];
    }

    public function collection()
    {

        // $from = "2022-05-25 22:38:49";
        // $to = "2022-05-31 22:38:49";

        return Guide::select([
            'order_id',
            'external_id',
            'pre_guide',
            'created_at',
            'invoice_contact', //Codigo del cliente
            'recipient_name',           
            'document_type',
            'document',
            'email_contact',
            'address_name',
            'city',
            'phone_contact',
            'country',
            'pieces',
            'kg',
            'declared',
            'invoice_number',       //Guia
            'dispatched', // Factura            
            'contact',
            'description',
            'novelty',     //Usuario 
            'delivery_office',
            'state',
            'updated_at',
        ])
        // ->date($from, $to)        
        ->get();
    }





    public function styles(Worksheet $sheet)
    {
        return
            $sheet->getStyle('1')->getFont()->setBold(true);
    }
}
