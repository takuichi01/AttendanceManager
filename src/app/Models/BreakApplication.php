<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'break_time_id',
        'before_break_start_time',
        'before_break_end_time',
        'after_break_start_time',
        'after_break_end_time',
    ];

    public function attendanceApplication()
    {
        return $this->belongsTo(AttendanceApplication::class, 'attendance_application_id');
    }
}
