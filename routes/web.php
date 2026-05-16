<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

// Mengarahkan halaman awal langsung ke index presensi
Route::get('/', function () {
    return redirect()->route('attendance.index');
});

// Resource routing otomatis menangani CRUD (Index, Create, Store, Edit, Update, Destroy)
Route::resource('attendance', AttendanceController::class);