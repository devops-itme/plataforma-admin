<?php

namespace App\Modules\OrderModule\Exports;

use App\Modules\OrderModule\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Modules\GuideModule\Guide;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Modules\ApiConnectionsModule\Models\Tealca;
use Illuminate\Support\Facades\DB;



class OrdersExportServices extends DefaultValueBinder implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($user_id, $date_start, $date_end)
    {

        $this->date_start = $date_start;
        $this->date_end = $date_end;
        $this->user_id = $user_id;
    }

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
            // __('guiaMe'),
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

        $date_start = $this->date_start;
        $date_end = $this->date_end;


        $from = request()->from;
        $to = request()->to;
        $name = request()->name;

        // dd($name);

        if (!isset($vector)) {
            $vector = null;
        }

        if ($date_start and $date_end) {

            $guides = DB::table('guides AS g')
                ->select(
                    'external_id',
                    DB::raw("DATE_FORMAT(g.created_at, '%Y/%m/%d %H:%i:%s') as formatted_dob"),
                    'g.branch_office', //Origen
                    'invoice_contact',
                    'recipient_name',
                    'g.document_type',
                    'document',
                    'email_contact',
                    'g.address_name',
                    'city',
                    'phone_contact',
                    'country',
                    'pieces',
                    'kg',
                    'declared',
                    'g.dispatched', // Factura
                    'pre_guide', //Guia
                    'contact',
                    'g.description',
                    'novelty',
                    'delivery_office',
                )
                ->where('external_id', '<>', null)
                ->where('country', '<>', 'PAN')
                ->join('orders as o', 'o.id', '=', 'g.order_id')
                ->join('users as u', 'u.id', '=', 'o.user_id')
                ->where('o.deleted_at', null)
                ->whereBetween(DB::raw('DATE(g.created_at)'), [$date_start, $date_end])
                ->where('u.id', $this->user_id)
                ->get();

            foreach ($guides as $guide) {
                // dd($guide);
                $order1 = $guide;
                $Tealca = new Tealca();
                $Tealca->login();
                $guideTracking = $Tealca->requestOrderStatus($guide->external_id);

                foreach ($guideTracking['data'][0]['tracking'] as $tracking) {
                    switch ($tracking['status']) {
                        case 'Creacion':
                            $order1->Status = 'VERIFICACION';
                            $order1->Fecha = date('Y/m/d H:i:s', strtotime($tracking['date']));
                            $vector[] = $order1;
                            break;

                        case 'Recepcion desde plataforma':
                            $order1->Status = 'RECEPTADO A BODEGA';
                            $order1->Fecha = date('Y/m/d H:i:s', strtotime($tracking['date']));
                            $vector[] = $order1;
                            break;

                        case 'Recepcion desde tienda':
                            $order1->Status = 'RECEPCION EN SUCURSAL';
                            $order1->Fecha = date('Y/m/d H:i:s', strtotime($tracking['date']));
                            $vector[] = $order1;
                            break;

                        case 'Despacho a tienda(tienda destino para entrega al cliente)':
                            $order1->Status = 'DESPACHO A SUCURSAL';
                            $order1->Fecha = date('Y/m/d H:i:s', strtotime($tracking['date']));
                            $vector[] = $order1;
                            break;

                        default:
                            $order1->Status = $tracking['status'];
                            $order1->Fecha = date('Y/m/d H:i:s', strtotime($tracking['date']));
                            $vector[] = $order1;
                    }
                    break;
                }
            }
        }

        return collect($vector);
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
