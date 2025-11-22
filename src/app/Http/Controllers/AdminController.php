<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StampCorrectionRequest;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\BreakTime;
use \App\Models\StaffUser;
use \App\Models\AttendanceApplication;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if (empty($request->input('date'))) {
            $date = Carbon::today()->toDateString();
        } else {
            $date = $request->input('date');
        }

        $attendances = Attendance::whereDate('date', $date)->orderBy('id', 'asc')->get();
        $date = Carbon::parse($date);
        return view('admin.attendances', compact('attendances', 'date'));
    }

    public function detail($id)
    {
        $attendance = Attendance::where('id', $id)->with('breakTimes')->firstOrFail();
        $break_count = $attendance->breakTimes->count();
        return view('admin.detail', compact('attendance', 'break_count'));
    }

    public function modify(StampCorrectionRequest $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $attendance->work_start_time = $request->input('work_start_time') !== null ? Carbon::parse($request->input('work_start_time'))->format('H:i:s') : null;
        $attendance->work_end_time = $request->input('work_end_time') !== null ? Carbon::parse($request->input('work_end_time'))->format('H:i:s') : null;
        $attendance->remarks = $request->input('remarks');
        $attendance->save();

        $applyBreakStartTimes = $request->input('break_start_time', []);
        $applyBreakEndTimes = $request->input('break_end_time', []);
        foreach ($attendance->breakTimes as $index => $breakTime) {
            $breakTime->break_start_time = $applyBreakStartTimes[$index] !== null ? Carbon::parse($applyBreakStartTimes[$index])->format('H:i:s') : null;
            $breakTime->break_end_time = $applyBreakEndTimes[$index] !== null ? Carbon::parse($applyBreakEndTimes[$index])->format('H:i:s') : null;
            $breakTime->save();
        }

        if ($request->input('add_break_start_time') != null && $request->input('add_break_end_time') != null) {
            $attendance->breakTimes()->create([
                'break_start_time' => Carbon::parse($request->input('add_break_start_time'))->format('H:i:s'),
                'break_end_time' => Carbon::parse($request->input('add_break_end_time'))->format('H:i:s'),
            ]);
        }

        return redirect()->route('admin.attendance.detail', ['id' => $id]);
    }

    public function indexStaffs()
    {
        $users = StaffUser::all();
        return view('admin.users', compact('users'));
    }

    public function indexStaffAttendances(Request $request, $id)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);
        $name = StaffUser::where('id', $id)->value('name');
        $attendances = Attendance::where('staff_id', $id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.user_attendances', compact('attendances', 'year', 'month', 'id', 'name'));
    }

    public function indexAllApplies()
    {
        $applications = AttendanceApplication::with('staffUser')->orderBy('created_at', 'asc')->get();
        return view('admin.all_applies', compact('applications'));
    }

    public function showApplication($id)
    {
        $application = AttendanceApplication::with('breakApplications')
            ->with('attendance')
            ->where('id', $id)
            ->firstOrFail();
        $break_count = $application->breakApplications->count();
        return view('admin.apply', compact('application', 'break_count'));
    }

    public function approve(Request $request, $id)
    {
        $application = AttendanceApplication::with('breakApplications')->where('id', $id)->firstOrFail();

        $attendance = $application->attendance;
        $attendance->delete();
        foreach ($attendance->breakTimes as $breakTime) {
            $breakTime->delete();
        }

        $newAttendance = Attendance::create([
            'staff_id' => $application->staff_id,
            'staff_name' => $application->staffUser->name,
            'date' => $attendance->date,
            'work_start_time' => $application->after_work_start_time,
            'work_end_time' => $application->after_work_end_time,
            'remarks' => $application->remarks,
            'status' => '退勤済',
        ]);
        foreach ($application->breakApplications as $breakApp) {
            $newAttendance->breakTimes()->create([
                'attendance_id' => $newAttendance->id,
                'break_start_time' => $breakApp->after_break_start_time,
                'break_end_time' => $breakApp->after_break_end_time,
            ]);
        }

        $application->approval_flag = 1; // 承認済
        $application->save();
        return redirect()->route('admin.show.application', ['id' => $id]);
    }
}
