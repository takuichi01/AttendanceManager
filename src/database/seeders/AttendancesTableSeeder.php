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
        $staffName = ['Staff User1', 'Staff User2'];
        $year = 2025;
        $Days = [14, 15, 16];

        for ($month = 10; $month <= 12; $month++) {
            // その月の日数を取得
            $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;

            foreach ($staffName as $staffId => $name) {
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    if ($month === 11 && in_array($day, $Days)) {
                        DB::table('attendances')->insert([
                            'staff_id' => $staffId+1,
                            'staff_name' => $name,
                            'date' => sprintf('%04d-%02d-%02d', $year, $month, $day),
                            'work_start_time' => '9:00:00',
                            'work_end_time' => '18:00:00',
                            'remarks' => null,
                            'status' => '退勤済',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        DB::table('attendances')->insert([
                            'staff_id' => $staffId+1,
                            'staff_name' => $name,
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
        }
    }
}
