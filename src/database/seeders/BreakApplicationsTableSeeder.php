<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BreakApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('break_applications')->insert([
            'attendance_application_id' => 1,
            'break_time_id' => 76,
            'before_break_start_time' => '12:00:00',
            'before_break_end_time' => '12:30:00',
            'after_break_start_time' => '12:00:00',
            'after_break_end_time' => '13:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('break_applications')->insert([
            'attendance_application_id' => 2,
            'break_time_id' => 106,
            'before_break_start_time' => '12:00:00',
            'before_break_end_time' => '12:30:00',
            'after_break_start_time' => '12:00:00',
            'after_break_end_time' => '14:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
