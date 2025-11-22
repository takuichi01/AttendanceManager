<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class Attendance extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'staff_id',
        'staff_name',
        'date',
        'work_start_time',
        'work_end_time',
        'remarks',
        'status',
    ];

    public function staffUser()
    {
        return $this->belongsTo(StaffUser::class, 'staff_id');
    }

    public function breakTimes()
    {
        return $this->hasMany(BreakTime::class, 'attendance_id')->orderBy('break_start_time', 'asc');
    }

    public function attendanceApplications()
    {
        return $this->hasMany(AttendanceApplication::class, 'attendance_id');
    }

    public function getWorkingHoursAttribute()
    {
        return Carbon::parse($this->work_end_time)->diffInMinutes($this->work_start_time);
    }
}
