<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert(DB::raw("
        INSERT INTO countries (id, name, state, created_at, updated_at, deleted_at) VALUES
        (1, 'Panama', 1, '2022-02-15 14:41:21', '2022-02-15 14:41:44', NULL);
        "));
    }
}
