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

    // 一旦AttendancesTableSeederに勤怠が存在するもののみ作成(１つだけ作成しないパターンも用意)
    public function run()
    {
        $param = [
            'attendance_id' => 76,
            'break_start_time' => '12:00:00',
            'break_end_time' => '12:30:00',
        ];
        DB::table('break_times')->insert($param);

        $param = [
            'attendance_id' => 77,
            'break_start_time' => '12:00:00',
            'break_end_time' => '12:30:00',
        ];
        DB::table('break_times')->insert($param);

        $param = [
            'attendance_id' => 77,
            'break_start_time' => '17:00:00',
            'break_end_time' => '18:00:00',
        ];
        DB::table('break_times')->insert($param);

        $param = [
            'attendance_id' => 78,
            'break_start_time' => '12:00:00',
            'break_end_time' => '13:00:00',
        ];
        DB::table('break_times')->insert($param);

        $param = [
            'attendance_id' => 106,
            'break_start_time' => '12:00:00',
            'break_end_time' => '12:30:00',
        ];
        DB::table('break_times')->insert($param);

        $param = [
            'attendance_id' => 107,
            'break_start_time' => '12:00:00',
            'break_end_time' => '12:30:00',
        ];
        DB::table('break_times')->insert($param);

        $param = [
            'attendance_id' => 107,
            'break_start_time' => '17:00:00',
            'break_end_time' => '18:00:00',
        ];
        DB::table('break_times')->insert($param);

        $param = [
            'attendance_id' => 108,
            'break_start_time' => '12:00:00',
            'break_end_time' => '13:00:00',
        ];
        DB::table('break_times')->insert($param);
    }
}
