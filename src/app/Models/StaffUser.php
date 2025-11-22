<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class StaffUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'staff_users';
    protected $guard = 'staff';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'staff_id');
    }

    public function attendanceApplications()
    {
        return $this->hasMany(AttendanceApplication::class, 'staff_id');
    }
}