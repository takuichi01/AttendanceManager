<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $staffId = 1; // スタッフIDを指定
        $staffName = 'Staff User';
        $year = 2025;
        $month = 11;
        
        // その月の日数を取得
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            DB::table('attendances')->insert([
                'staff_id' => $staffId,
                'staff_name' => $staffName,
                'date' => sprintf('%04d-%02d-%02d', $year, $month, $day),
                'work_start_time' => null,
                'work_end_time' => null,
                'remarks' => null,
                'status' => '勤務外',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
