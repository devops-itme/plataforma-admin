<?php

use App\Modules\RoleModule\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Config::get('const.roles');
        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
            ]);
        }
    }
}
