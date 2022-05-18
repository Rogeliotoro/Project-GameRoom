<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'name' => 'rogelio',
                'email' => 'rogel@toro.com',
                'password' => '1234',
                'nickname' => 'rogel'
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'Messi',
                'email' => 'lionel@messi.com',
                'password' => '12345',
                'nickname' => 'pulga'
            ]
        );
    }
}
