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
<<<<<<< HEAD
        $this->call(ParameterValueSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
=======
        $this->call([
            RoleSeeder::class,
            UserSeeder::class
        ]);
>>>>>>> 7110de5377e454e03f6686f4f11fb51a8c171e68
    }
}
