<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\CustomAuthenticatedSessionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;


// 管理者用ログアウトルート（Fortifyのコントローラーを流用）
Route::post('/admin/logout', function (Illuminate\Http\Request $request) {
    config(['fortify.guard' => 'admin']);
    return app(AuthenticatedSessionController::class)->destroy($request);
})->name('admin.logout');
// Fortifyが /register, /login を自動登録するのでコメントアウト
// Route::get('/register', function () {
//     return view('auth.register');
// });

// Route::get('/login', function () {
//     return view('auth.user_login');
// });
Route::post('/login', [CustomAuthenticatedSessionController::class, 'store'])->name('login');

// 管理者ログイン用ルート
Route::get('/admin/login', function () {
    config(['fortify.guard' => 'admin']);
    return view('auth.admin_login');
})->name('admin.login.form');

Route::post('/admin/login', [CustomAuthenticatedSessionController::class, 'store'])->name('admin.login');

// 認証が必要なルート（スタッフ用）
Route::middleware(['redirect.if.not.staff'])->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clockIn');
    Route::post('/attendance/break-in', [AttendanceController::class, 'breakIn'])->name('attendance.breakIn');
    Route::post('/attendance/break-out', [AttendanceController::class, 'breakOut'])->name('attendance.breakOut');
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clockOut');
    Route::get('/attendance/list', [AttendanceController::class, 'index'])->name('attendance.list');
    Route::get('/attendance/detail/{id}', [AttendanceController::class, 'detail'])->name('attendance.detail');
    Route::post('/attendance/detail/{id}', [AttendanceController::class, 'apply'])->name('attendance.apply');
    Route::get('/stamp_correction_request/list', [AttendanceController::class, 'indexApply'])->name('attendance.indexApply');
});

// 認証が必要なルート（管理者用）
Route::middleware(['redirect.if.not.admin'])->prefix('admin')->group(function () {
    Route::get('/attendance/list', [AdminController::class, 'index'])->name('admin.attendances');
    Route::get('/attendances/{id}', [AdminController::class, 'detail'])->name('admin.attendance.detail');
    Route::post('/attendances/{id}', [AdminController::class, 'modify'])->name('admin.attendance.modify');
    Route::get('/staff/list', [AdminController::class, 'indexStaffs'])->name('admin.index.staffs');
    Route::get('/attendance/staff/{id}', [AdminController::class, 'indexStaffAttendances'])->name('admin.user.attendances');
    Route::get('/stamp_correction_request/list', [AdminController::class, 'indexAllApplies'])->name('admin.index.applies');
    Route::get('/stamp_correction_request/approve/{id}', [AdminController::class, 'showApplication'])->name('admin.show.application');
    Route::post('/stamp_correction_request/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
});