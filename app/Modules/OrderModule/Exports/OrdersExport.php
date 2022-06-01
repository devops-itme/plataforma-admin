<?php

namespace App\Modules\OrderModule\Exports;

use App\Modules\OrderModule\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Modules\GuideModule\Guide;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class OrdersExport implements  FromCollection,WithHeadings, WithStyles 
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

        //  $from = "2022-05-23 18:07:31";
        //  $to = "2022-05-25 18:07:31";        

        return $guias= Guide::select([
            'order_id',
            'external_id',
            'pre_guide',
            'created_at',
            'branch_office', //Origen
            'invoice_contact',
            'contact',
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
            'novelty',                         
            'app_status',
            'delivery_office',  
            'state',
            'updated_at',
        ])
            // ->date($from, $to)
            ->get();
    }


    public function styles(Worksheet $sheet)
    {
        return  $sheet->getStyle('1')->getFont()->setbold(true);
    }

    

}
