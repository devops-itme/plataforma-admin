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
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class OrdersExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize,WithCustomValueBinder
{
    /**
     * @return \Illuminate\Support\Collection
     */

     // set the preferred date format
    private $date_format = 'Y-m-d';

    // set the columns to be formatted as dates
    private $date_columns = ['A'];


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

        return $guias = Guide::select([
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

    

    // public function bindValue(Cell $cell, $value)
    // {
    //     if (in_array($cell->getColumn(), $this->date_columns)) {
    //         $cell->setValueExplicit(Date::excelToDateTimeObject($value)->format($this->date_format), DataType::TYPE_STRING);

    //         return true;
    //     }

    //     // else return default behavior
    //     return parent::bindValue($cell, $value);
    // }
}
