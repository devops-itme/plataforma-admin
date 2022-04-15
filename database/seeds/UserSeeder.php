<?php

use App\Modules\UserModule\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //id => data[
        //'parent_id' => 0
        //"name" => 1
        //"last_name" => 2
        //"document_type" => 3
        //"document_number" => 4
        //"email" => 5
        //"phone" => 6
        //"password" => 7
        //"role" => 8
        //"state" => 9
        //]
        $users =
            [
                1 => [
                    null,
                    "Admin",
                    "ME",
                    null,
                    null,
                    "admin@me.com",
                    null,
                    Hash::make("me2022"),
                    1,
                    1,
                ],
            ];

        foreach ($users as $id => $user) {
            User::create([
                'parent_id' => $user[0],
                "name" => $user[1],
                "last_name" => $user[2],
                "document_type" => $user[3],
                "document_number" => $user[4],
                "email" => $user[5],
                "phone" => $user[6],
                "password" => $user[7],
                "role" => $user[8],
                "state" => $user[9],
            ]);
        }
    }
}
