<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \App\Role::create([
            'slug' => 'admin',
            'name' => 'Admin',
        ]);
        \App\User::create([
            'firstname' => 'Hakan',
            'lastname' => 'Karabulut',
            'username' => 'hakan',
            'email' => '34hk1286@gmail.com',
            'password' => bcrypt('123456'),
            // 'avatar' => 'images/hk.jpg',
            'role_id' => 1
        ]);
        \App\User::create([
            'firstname' => 'Halil İbrahim',
            'lastname' => 'Özdemir',
            'username' => 'halil',
            'email' => 'wale_x@hotmail.com',
            'password' => bcrypt('123456'),
            // 'avatar' => 'images/5.jpg',
            'api_token' => 'Tti34sJuS2nGc9Zi7tmOkD9IMsZF9QmECa0RyEUABBvZ3hq4jAzoRODBBpgR',
            'role_id' => 1
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
