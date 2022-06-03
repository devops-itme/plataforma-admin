<?php

use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\StatusMatrixModule\StatusMatrix;
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
        StatusMatrix::query()->delete();
        $system_status = Config::get('const.system_status');
        $issues_array = Config::get('const.parameters.issues');

        $issues = ParameterValue::whereIn('name', $issues_array)->get(['id']);
        $times = count($issues);
        $issues = str_replace('}', "", str_replace('id":', "", str_replace('{"', "", $issues, $times), $times), $times);
        
        foreach ($system_status as $key => $values) {
            $scope = ParameterValue::where('name', $key)
                ->whereHas('getParameter', function ($q) {
                    $q->where('name', 'scopes');
                })->first();
            foreach ($values as $value) {
                StatusMatrix::create([
                    'name' => $value,
                    'scope_id' => $scope->id,
                    'issues' =>  $issues,
                ]);
            }
        }
    }
}
