<?php

use App\Module;
use App\Permission;
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
            $name = $data['reference'];
            if (count($data['permission'])) {
                $permission = Config::get("const.modules.".$name.".permission");

                foreach ($permission as $key => $data) {
                    $permission = Permission::create([
                        'role_id' =>$data['role_id'], 'module_id' =>$module->id, 'actions'=>$data['actions'],
                    ]);
                }
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
    // public function createPermissions($id, $modules)
    // {
    //     foreach($modules as $key => $data){
    //         $permission = Permission::create([
    //             'role_id'=>$data['role_id'],'module_id'=>$id, 'actions'=>$data['actions']
    //         ]);
    //         if (count($data['permission'])) {
    //             $this->createPermissions($permission->id, $data['permission']);
    //         }
    //     }
    // }
}
