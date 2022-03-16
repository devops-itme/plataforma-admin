<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ParameterValueSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            ZonesSeeder::class,
            ModuleSeeder::class,
            MessengerSeeder::class,
            StatusMatrixSeeder::class,
        ]);

    }
}
