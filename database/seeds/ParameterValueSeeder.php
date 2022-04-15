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
        $parameters = Config::get('const.parameters');
        foreach ($parameters as $id => $values) {
            $parameter = Parameter::create([
                'name' => $id
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
