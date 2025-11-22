<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'password' => Hash::make('staff_pass'),
        ];
        DB::table('staff_users')->insert($param);
    }
}
