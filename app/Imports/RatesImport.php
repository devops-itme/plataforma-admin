<?php

namespace App\Imports;

use App\Modules\NeighborhoodModule\Neighborhood;
use App\Modules\RateModule\Rate;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RatesImport implements ToModel, WithHeadingRow
{

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row) {
            if (!isset($row['barrio'])) {
                dd($row);
            }
            // dd(trim($row['barrio']));
            $neighborhood_name = str_replace("  ", " ", trim($row['barrio']));
            $neighborhood = Neighborhood::where('name', $neighborhood_name)->first();
            if (!$neighborhood) {
                dd($row['barrio']);
            }
            return Rate::create([
                'neighborhood_id' => $neighborhood->id,
                'base_value' => $row['tarifamotoadicional'],
                'state' => 1
            ]);
        }
    }
}
