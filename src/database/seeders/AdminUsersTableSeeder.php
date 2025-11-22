<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin_pass')
        ];

        DB::table('admin_users')->insert($param);
    }
}
