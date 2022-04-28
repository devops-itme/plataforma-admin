<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert(DB::raw("
        INSERT INTO provinces (id, country_id, name, state, created_at, updated_at, deleted_at) VALUES
        (1, 1, 'BOCAS DEL TORO', 1, '2022-02-15 15:15:58', '2022-02-15 15:15:58', NULL),
        (2, 1, 'CHIRIQUI', 1, '2022-02-15 15:15:58', '2022-02-15 15:15:58', NULL),
        (3, 1, 'COCLE', 1, '2022-02-15 15:15:58', '2022-02-15 15:15:58', NULL),
        (4, 1, 'COLON', 1, '2022-02-15 15:15:58', '2022-02-15 15:15:58', NULL),
        (5, 1, 'COMARCA EMBERA', 1, '2022-02-15 15:15:58', '2022-02-15 15:15:58', NULL),
        (6, 1, 'COMARCA KUNA YALA', 1, '2022-02-15 15:15:58', '2022-02-15 15:15:58', NULL),
        (7, 1, 'COMARCA NGOBE BUGLE', 1, '2022-02-15 15:15:58', '2022-02-15 15:15:58', NULL),
        (8, 1, 'COMARCA WARGANDI', 1, '2022-02-15 15:15:58', '2022-02-15 15:15:58', NULL),
        (9, 1, 'DARIEN', 1, '2022-02-15 15:15:58', '2022-02-15 15:15:58', NULL),
        (10, 1, 'HERRERA', 1, '2022-02-15 15:15:58', '2022-02-15 15:15:58', NULL),
        (11, 1, 'LOS SANTOS', 1, '2022-02-15 15:15:58', '2022-02-15 15:15:58', NULL),
        (12, 1, 'PANAMA', 1, '2022-02-15 15:15:58', '2022-02-15 15:15:58', NULL),
        (13, 1, 'PANAMA OESTE', 1, '2022-02-15 15:15:58', '2022-02-15 15:15:58', NULL),
        (14, 1, 'VERAGUAS', 1, '2022-02-15 15:15:58', '2022-02-15 15:15:58', NULL);
        "));
    }
}
