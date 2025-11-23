<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attendance_applications')->insert([
            'attendance_id' => 76,
            'staff_id' => 1,
            'attendance_date' => "2025-11-14",
            'before_work_start_time' => '9:00:00',
            'before_work_end_time' => '18:00:00',
            'after_work_start_time' => '9:00:00',
            'after_work_end_time' => '20:00:00',
            'remarks' => 'テスト用承認1（承認前）',
            'approval_flag' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('attendance_applications')->insert([
            'attendance_id' => 106,
            'staff_id' => 2,
            'attendance_date' => "2025-11-14",
            'before_work_start_time' => '9:00:00',
            'before_work_end_time' => '18:00:00',
            'after_work_start_time' => '9:00:00',
            'after_work_end_time' => '19:00:00',
            'remarks' => 'テスト用承認2（承認前）',
            'approval_flag' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('attendance_applications')->insert([
            'attendance_id' => 78,
            'staff_id' => 1,
            'attendance_date' => "2025-11-16",
            'before_work_start_time' => '9:00:00',
            'before_work_end_time' => '18:00:00',
            'after_work_start_time' => '9:00:00',
            'after_work_end_time' => '18:00:00',
            'remarks' => 'テスト用承認1（承認後）',
            'approval_flag' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('attendance_applications')->insert([
            'attendance_id' => 108,
            'staff_id' => 2,
            'attendance_date' => "2025-11-16",
            'before_work_start_time' => '9:00:00',
            'before_work_end_time' => '18:00:00',
            'after_work_start_time' => '9:00:00',
            'after_work_end_time' => '18:00:00',
            'remarks' => 'テスト用承認2（承認後）',
            'approval_flag' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
