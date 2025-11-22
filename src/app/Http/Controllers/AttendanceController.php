<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StampCorrectionRequest;
use App\Models\Attendance;
use App\Models\AttendanceApplication;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class AttendanceController extends Controller
{
    public function show()
    {
        $today = Carbon::today()->toDateString();
        $userId = Auth::guard('staff')->id();

        $attendance = Attendance::where('staff_id', $userId)
            ->where('date', $today)
            ->first();

        $status = $attendance ? $attendance->status : '勤務外';

        return view('user.attendance', compact('status'));
    }

    public function clockIn()
    {
        $userId = Auth::guard('staff')->id();
        $staffName = Auth::guard('staff')->user()->name;
        $today = Carbon::today()->toDateString();

        $attendance = Attendance::firstOrCreate(
            ['staff_id' => $userId, 'date' => $today],
            ['staff_name' => $staffName]
        );

        $attendance->work_start_time = Carbon::now()->format('H:i:s');
        $attendance->status = '出勤中';
        $attendance->save();

        return redirect()->route('attendance.show');
    }

    public function breakIn()
    {
        $userId = Auth::guard('staff')->id();
        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('staff_id', $userId)
            ->where('date', $today)
            ->first();

        if ($attendance && $attendance->status === '出勤中') {
            $attendance->breakTimes()->create([
                'break_start_time' => Carbon::now()->format('H:i:s'),
            ]);
            $attendance->status = '休憩中';
        }
        $attendance->save();
        return redirect()->route('attendance.show');
    }

    public function breakOut()
    {
        $userId = Auth::guard('staff')->id();
        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('staff_id', $userId)
            ->where('date', $today)
            ->first();

        if ($attendance && $attendance->status === '休憩中') {
            $breakTime = $attendance->breakTimes()
                ->whereNull('break_end_time')
                ->latest()
                ->first();

            $breakTime->break_end_time = Carbon::now()->format('H:i:s');
            $breakTime->save();

            $attendance->status = '出勤中';
        }
        $attendance->save();
        return redirect()->route('attendance.show');
    }

    public function clockOut()
    {
        $userId = Auth::guard('staff')->id();
        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('staff_id', $userId)
            ->where('date', $today)
            ->first();

        $attendance->work_end_time = Carbon::now()->format('H:i:s');
        $attendance->status = '退勤済';
        $attendance->save();

        return redirect()->route('attendance.show');
    }

    public function index(Request $request)
    {
        $userId = Auth::guard('staff')->id();
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);
        $attendances = Attendance::where('staff_id', $userId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'asc')
            ->get();

        return view('user.list', compact('attendances', 'year', 'month'));
    }

    public function detail($id)
    {
        $attendance = Attendance::with('breakTimes')->findOrFail($id);
        $break_count = $attendance->breakTimes->count();

        $applying_flg = $attendance->attendanceApplications->contains('approval_flag', 0);
        return view('user.detail', compact('attendance', 'break_count', 'applying_flg'));
    }

    public function apply(StampCorrectionRequest $request, $id)
    {
        $applyAttendance = $request;
        $attendance = Attendance::with('breakTimes')->findOrFail($id);

        $newApplyAttendance = $attendance->attendanceApplications()->create([
            'staff_id' => $attendance->staff_id,
            'attendance_date' => $attendance->date,
            'before_work_start_time' => $attendance->work_start_time,
            'before_work_end_time' => $attendance->work_end_time,
            'after_work_start_time' => $applyAttendance->input('work_start_time') !== null ? Carbon::parse($applyAttendance->input('work_start_time'))->format('H:i:s') : null,
            'after_work_end_time' => $applyAttendance->input('work_end_time') !== null ? Carbon::parse($applyAttendance->input('work_end_time'))->format('H:i:s') : null,
            'remarks' => $applyAttendance->input('remarks'),
            'approval_flag' => '0', // 未承認
        ]);

        // 休憩時間の更新
        $applyBreakStartTimes = $applyAttendance->input('break_start_time', []);
        $applyBreakEndTimes = $applyAttendance->input('break_end_time', []);

        foreach ($attendance->breakTimes as $index => $breakTime) {
            $newApplyAttendance->breakApplications()->create([
                'break_time_id' => $breakTime->id,
                'before_break_start_time' => $breakTime->break_start_time,
                'before_break_end_time' => $breakTime->break_end_time,
                'after_break_start_time' => Carbon::parse($applyBreakStartTimes[$index] ?? null)->format('H:i:s'),
                'after_break_end_time' => Carbon::parse($applyBreakEndTimes[$index] ?? null)->format('H:i:s'),
            ]);
        }

        // 新しい休憩時間の追加
        if ($applyAttendance->input('add_break_start_time') != null && $applyAttendance->input('add_break_end_time') != null) {
            $newApplyAttendance->breakApplications()->create([
                'break_time_id' => null, // 該当する休憩レコードがない
                'before_break_start_time' => null,
                'before_break_end_time' => null,
                'after_break_start_time' => Carbon::parse($applyAttendance->input('add_break_start_time'))->format('H:i:s'),
                'after_break_end_time' => Carbon::parse($applyAttendance->input('add_break_end_time'))->format('H:i:s'),
            ]);
        }

        return redirect()->route('attendance.detail', ['id' => $id]);
    }

    public function indexApply()
    {
        $userId = Auth::guard('staff')->id();
        $applications = AttendanceApplication::where('staff_id', $userId)
            ->with('staffUser')
            ->with('attendance')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('user.stamp_correction_request', compact('applications'));
    }
}
