<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\PerformanceTaskController;
use App\Http\Controllers\PerformanceFinanceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\WorkPackageController;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test', function () {
//     return view('test');
// });

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/perencanaan', [PerencanaanController::class, 'index'])->name('perencanaan');
Route::get('/realisasi', [RealisasiController::class, 'index'])->name('realisasi');
Route::get('/kanban', [KanbanController::class, 'index'])->name('kanban');
Route::get('/task', [TaskController::class, 'index'])->name('task');
Route::get('/performance-task', [PerformanceTaskController::class, 'index'])->name('performance-task');
Route::get('/performance-finance', [PerformanceFinanceController::class, 'index'])->name('performance-finance');
Route::get('/timesheet', [TimesheetController::class, 'index'])->name('timesheet');
Route::get('/work-package', [WorkPackageController::class, 'index'])->name('work-package');
Route::get('/work-package/{volume_id}', [WorkPackageController::class, 'detail'])->name('work-package.detail');