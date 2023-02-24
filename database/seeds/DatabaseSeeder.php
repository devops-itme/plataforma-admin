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
            ModuleSeeder::class,
            MessengerSeeder::class,
            StatusMatrixSeeder::class,
            CountrySeeder::class,
            ProvinceSeeder::class,
            DistrictSeeder::class,
            CorregimientoSeeder::class,
            NeighborhoodSeeder::class,
            CustomerSeeder::class,
            CoordinadoraCitiesSeeder::class,
        ]);
    }
}
