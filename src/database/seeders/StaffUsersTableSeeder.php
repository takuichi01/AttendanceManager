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
            'name' => 'Staff User1',
            'email' => 'staff1@example.com',
            'password' => Hash::make('staff1_pass'),
        ];
        DB::table('staff_users')->insert($param);

        $param = [
            'name' => 'Staff User2',
            'email' => 'staff2@example.com',
            'password' => Hash::make('staff2_pass'),
        ];
        DB::table('staff_users')->insert($param);
    }
}
