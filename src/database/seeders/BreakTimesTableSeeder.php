<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BreakTimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'attendance_id' => 1,
            'break_start_time' => '12:00:00',
            'break_end_time' => '12:30:00',
        ];
        DB::table('break_times')->insert($param);
    }
}
