<?php

namespace App\Modules\OrderModule\Exports;

use App\Modules\OrderModule\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Modules\GuideModule\Guide;

class OrdersExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Guide::get([
            'order_id',
            'invoice_number',
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
            'zone',       //Guia
            'dispatched', // Factura            
            'contact',
            'description',
            'novelty',     //Usuario 
            'delivery_office',
            'state',
            'updated_at',
        ]);
    }

    public function headings(): array
    {
        return [
            __('#'),
            __('numGuia'),
            __('guiaMe'),
            __('FechaCreacion'),
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
            __('preGuia'),
            __('numFactura'),           
            __('nameContact'),
            __('observ'),
            __('usuario'),
            __('oficinaDeEntrega'),
            __('status'),
            __('fechaStatus'),

        ];
    }

    public function styles(Worksheet $sheet)
    {
        return
            $sheet->getStyle('1')->getFont()->setBold(true);
    }
}