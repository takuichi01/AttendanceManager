<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'attendance_date',
        'before_work_start_time',
        'before_work_end_time',
        'after_work_start_time',
        'after_work_end_time',
        'remarks',
        'approval_flag',
    ];

    public function breakApplications()
    {
        return $this->hasMany(BreakApplication::class, 'attendance_application_id');
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id');
    }

    public function staffUser()
    {
        return $this->belongsTo(StaffUser::class, 'staff_id');
    }
}
