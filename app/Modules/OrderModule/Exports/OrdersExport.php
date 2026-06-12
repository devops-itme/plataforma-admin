<?php

namespace App\Modules\OrderModule\Exports;

use App\Modules\OrderModule\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Modules\GuideModule\Guide;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Modules\ApiConnectionsModule\Models\Tealca;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class OrdersExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    protected $from;
    protected $to;
    protected $name;

    public function __construct($from = null, $to = null, $name = null)
    {
        $this->from = $from ?: Carbon::now()->subWeek()->toDateString();
        $this->to = $to ?: Carbon::now()->toDateString();
        $this->name = $name;
    }

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
        $from = $this->from;
        $to = $this->to;
        $name = $this->name;

        $query = DB::table('tealca_datas as t')
            ->select(
                'g.external_id',
                'g.pre_guide',
                DB::raw("DATE_FORMAT(g.created_at, '%Y/%m/%d %H:%i:%s') as formatted_dob"),
                'g.branch_office', //Origen
                'g.invoice_contact',
                'g.recipient_name',
                'g.document_type',
                'g.document',
                'g.email_contact',
                'g.address_name',
                'g.city',
                'g.phone_contact',
                'g.country',
                'g.pieces',
                'g.kg',
                'g.declared',
                'g.invoice_number', //Guia
                'g.dispatched', // Factura
                'g.contact',
                'g.description',
                'g.novelty',
                'g.delivery_office',
                't.status',
                't.date_status'
            )
            ->where('g.external_id', '<>', null)
            ->where('g.country', '<>', 'PAN')
            ->whereNull('t.deleted_at')
            ->whereNull('g.deleted_at')
            ->join('guides as g', 'g.id', '=', 't.guide_id')
            ->join('orders as o', 'o.id', '=', 'g.order_id')
            ->join('users as u', 'u.id', '=', 'o.user_id')
            ->where('o.deleted_at', null);
            // ->where(DB::raw('concat(u.name," ",u.last_name)'), '<>', 'Admin ME');

        $query->whereBetween(DB::raw('DATE(g.created_at)'), [$from, $to]);

        if ($name) {
            $query->where('o.order_number', 'like', '%' . $name . '%');
        }

        return $query->orderBy('g.created_at', 'DESC')->get();
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
