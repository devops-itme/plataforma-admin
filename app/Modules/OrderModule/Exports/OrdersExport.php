<?php

namespace App\Modules\OrderModule\Exports;

use App\Modules\OrderModule\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Modules\GuideModule\Guide;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use App\Modules\ApiConnectionsModule\Models\Tealca;
use Illuminate\Support\Facades\DB;





class OrdersExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    
     
    
     
    public function map($guide): array
    {
        return [
            $guide->external_id,
            $guide->pre_guide,
            $guide->created_at,            
            $guide->branch_office,
            $guide->invoice_contact,
            $guide->recipient_name,
            $guide->document_type,
            $guide->document,
            $guide->email_contact,
            $guide->address_name,
            $guide->city,
            $guide->phone_contact,
            $guide->country,
            $guide->pieces,
            $guide->kg,
            $guide->declared,
            $guide->invoice_number,
            $guide->dispatched,
            $guide->contact,
            $guide->description,
            $guide->novelty,
            $guide->delivery_office,

        ];
    }

    public function headings(): array
    {
        return [
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

        $guides = Guide::select(
            'external_id',
            'pre_guide',
            DB::raw('DATE_FORMAT(created_at, "%Y/%m/%d %H:%i:%s") as formatted_dob'),
            'branch_office', //Origen
            'invoice_contact',
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
            'invoice_number', //Guia
            'dispatched', // Factura            
            'contact',
            'description',
            'novelty',
            'delivery_office',
        )         
            ->where('external_id', '<>', null)
            ->where('country', '<>', 'PAN')
            ->date(request()->from, request()->to)
            ->get();

        foreach ($guides as $guide) {
            $order1 = json_decode($guide);
            // dd($order1['created_at']);
            $Tealca = new Tealca();
            $Tealca->login();
            $guideTracking = $Tealca->requestOrderStatus($guide->external_id);

            // $statuses = json_decode($guideTracking)->tracking;
            $statuses = $guideTracking['data'][0]['tracking'][0];
            // dd($statuses);
            $status   = $guideTracking['data'][0]['tracking'][0]['status'];

            foreach ($statuses as $status) {
                if ($status ==   'Creacion') {
                    // $order1->state = $statuses['description'];                   
                    $v1=$order1->Status = $statuses['status'];
                    $order1->Fecha = date('Y/m/d H:i:s', strtotime($statuses['date']));
                    // $order1->description = $statuses['description'];
                    $vector[] = $order1;
                }
            }
        }

        if(!isset($vector)){
           $vector=null;
        }
        return collect($vector);
        //  return $guides;
    }


    public function styles(Worksheet $sheet)
    {
        return  $sheet->getStyle('1')->getFont()->setbold(true);
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,            

        ];
    }
}
