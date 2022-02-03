<?php

use App\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modulos = Module::insert([
            //MODULES
            ['name' => 'Cliente', 'reference' => 'customers', 'parent_id' => null, 'icon' => '<i class="fas fa-home" style="font-size: 20px;"></i>', 'created_at' => now(), 'updated_at' => now(), 'state' => 1],
            ['name' => 'Mensajero', 'reference' => 'messengers', 'parent_id' => null, 'icon' => '<i class="fas fa-home" style="font-size: 20px;"></i>', 'created_at' => now(), 'updated_at' => now(), 'state' => 1],
            ['name' => 'Parametros', 'reference' => 'parameters', 'parent_id' => null, 'icon' => '<i class="fas fa-home" style="font-size: 20px;"></i>', 'created_at' => now(), 'updated_at' => now(), 'state' => 1],
            ['name' => 'Usuarios', 'reference' => 'users', 'parent_id' => null, 'icon' => '<i class="fas fa-home" style="font-size: 20px;"></i>', 'created_at' => now(), 'updated_at' => now(), 'state' => 1],
            ['name' => 'Ordenes', 'reference' => 'orders', 'parent_id' => null, 'icon' => '<i class="fas fa-home" style="font-size: 20px;"></i>', 'created_at' => now(), 'updated_at' => now(), 'state' => 1],
            ['name' => 'Tarifas', 'reference' => 'rates', 'parent_id' => null, 'icon' => '<i class="fas fa-home" style="font-size: 20px;"></i>', 'created_at' => now(), 'updated_at' => now(), 'state' => 1],
            ['name' => 'Zonas', 'reference' => 'zones', 'parent_id' => null, 'icon' => '<i class="fas fa-home" style="font-size: 20px;"></i>', 'created_at' => now(), 'updated_at' => now(), 'state' => 1],
            ['name' => 'Informes', 'reference' => 'reports', 'parent_id' => null, 'icon' => '<i class="fas fa-home" style="font-size: 20px;"></i>', 'created_at' => now(), 'updated_at' => now(), 'state' => 1],
        ]);
    }
}
