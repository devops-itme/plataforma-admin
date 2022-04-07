<?php

use App\ParameterValue;
use App\StatusMatrix;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class StatusMatrixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $system_status = Config::get('const.system_status');
        foreach ($system_status as $key => $values) {
            $scope = ParameterValue::where('name', $key)
                ->whereHas('getParameter', function ($q) {
                    $q->where('name', 'scopes');
                })->first();
            foreach ($values as $value) {
                StatusMatrix::create([
                    'name' => $value,
                    'scope_id' => $scope->id,
                    'issue_id' => null,
                ]);
            }
        }
    }
}
