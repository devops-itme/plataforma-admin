<?php

use App\Modules\ParametersModule\Parameter;
use App\Modules\ParameterValueModule\ParameterValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class ParameterValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $editable_parameters = Config::get('const.editable_parameters');
        $parameters = Config::get('const.parameters');
        foreach ($parameters as $key => $values) {
            $parameter = Parameter::create([
                'name' => $key,
                'editable' => in_array($key, $editable_parameters) ? 1 : 0
            ]);
            foreach ($values as $value) {
                ParameterValue::create([
                    'parameter_id' => $parameter->id,
                    'name' => $value
                ]);
            }
        }
    }
}
