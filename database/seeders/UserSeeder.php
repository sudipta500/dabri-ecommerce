<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_auths')->insert([
            'name'=>'admin',
            'password'=>Crypt::encrypt('admin@123'),

        ]);
        DB::table('users')->insert([
            'name'=>'user',
            'email'=>'user@gmail.com',
            'password'=>Crypt::encrypt('123456789'),
        ]);

    }
}
