<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class BreakTime extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'attendance_id',
        'break_start_time',
        'break_end_time',
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id');
    }

    public function getBreakDurationAttribute()
    {
        return Carbon::parse($this->break_end_time)->diffInMinutes($this->break_start_time);
    }
}
