<?php

namespace App\Modules\ApiConnectionsModule\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;

class TealcaInformExport implements FromArray,WithHeadings,WithStyles
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function styles(Worksheet $sheet)
    {

        $start = 2;
        $end = count($this->data)+1;


       // dd('D'.$start.':D'.$end);


        $sheet->getStyle('1')->getFont()->setBold(true);

        $conditional1 = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
        $conditional1->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CONTAINSTEXT);
        $conditional1->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_CONTAINSTEXT);
        $conditional1->setText('Incidencia');
        $conditional1->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->GetEndColor()->setARGB('FFFF0000');
        $conditional1->getStyle()->getFont()->setBold(true);

        $conditional2 = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
        $conditional2->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CONTAINSTEXT);
        $conditional2->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_CONTAINSTEXT);
        $conditional2->setText('INCIDENCIA');
        $conditional2->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->GetEndColor()->setARGB('FFFF0000');
        $conditional2->getStyle()->getFont()->setBold(true);

        $conditionalStyles = $sheet/*->getActiveSheet()*/->getStyle('D'.$start.':D'.$end)->getConditionalStyles();
        $conditionalStyles[] = $conditional1;
        $conditionalStyles[] = $conditional2;

        //dd($conditionalStyles);

        $sheet->/*getActiveSheet()->*/getStyle('D'.$start.':D'.$end)->setConditionalStyles($conditionalStyles);


    }

    public function headings(): array {
        return [
            "idOrden","numGuia","OrigenNombre","Status","FechaStatus","UltimoEvento"
        ];
    }

    public function array(): array
    {
        return $this->data;
    }
}
