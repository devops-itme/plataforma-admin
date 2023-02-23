<?php

namespace App\Exports;


use App\Modules\OrderModule\CoordinadoraOrder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CoordinadoraGuidesExport implements FromView, ShouldAutoSize, WithEvents
{
    protected $guideData;
    protected $batch;

    public function __construct($guides, $batchData)
    {
        $this->guideData = $guides;
        $this->batch = $batchData;
    }

    public function view(): View
    {
        return view('exports.coordinadoraGuidesExport', [
            'guideData' => $this->guideData,
            'batch' => $this->batch
        ]);
    }

    //Cell fromatting
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('Q2:W3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getStyle('A1:W3')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'D7BDE2'],]);
                
                $event->sheet->getStyle('A1:W3')->applyFromArray([
                    'font' =>[
                        'bold'=>true
                    ], 
                ]);
                $event->sheet->mergeCells('A1:P1');
                $event->sheet->mergeCells('Q1:W1');
                
                $event->sheet->getStyle('A1:P3')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $event->sheet->getStyle('Q1:W1')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $event->sheet->getStyle('A2:W2')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $event->sheet->getStyle('Q1:W3')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'N' => NumberFormat::FORMAT_NUMBER_00,
            'S' => NumberFormat::FORMAT_NUMBER_00,
            'T' => NumberFormat::FORMAT_NUMBER_00,
            'U' => NumberFormat::FORMAT_NUMBER_00,
            'V' => NumberFormat::FORMAT_NUMBER_00,            
        ];
    }
}
