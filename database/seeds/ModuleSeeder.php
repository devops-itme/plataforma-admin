<?php

use App\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = Config::get('const.modules');
        foreach ($modules as $key => $data) {
            $module = Module::create([
                'name' => $data['name'], 'reference' => $data['reference'], 'icon' => '', 'position' => $data['position']
            ]);
            if (count($data['children'])) {
                $this->createChildren($module->id, $data['children']);
            }
        }
    }

    public function createChildren($id, $modules)
    {
        foreach ($modules as $key => $data) {
            $module = Module::create([
                'name' => $data['name'], 'reference' => $data['reference'], 'parent_id' => $id, 'icon' => '', 'position' => $data['position']
            ]);
            if (count($data['children'])) {
                $this->createChildren($module->id, $data['children']);
            }
        }
    }
}
