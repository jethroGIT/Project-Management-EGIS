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
use App\Http\Controllers\ResourceManagementController;
use App\Http\Controllers\RolesManagementController;


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
Route::get('/performance-task/{volume_id}', [PerformanceTaskController::class, 'detail'])->name('performance-task.detail');

Route::get('/performance-finance', [PerformanceFinanceController::class, 'index'])->name('performance-finance');
Route::get('/timesheet', [TimesheetController::class, 'index'])->name('timesheet');
Route::get('/timesheet/{volume_id?}', [TimesheetController::class, 'detail'])->name('timesheet.detail');

Route::get('/work-package', [WorkPackageController::class, 'index'])->name('work-package');
Route::get('/work-package/{volume_id}', [WorkPackageController::class, 'detail'])->name('work-package.detail');
Route::put('/work-package/{volume_id}/hresource-edit', [WorkPackageController::class, 'editHResource'])->name('work-package.hResource.edit');

Route::get('/work-package/task/{taskId}', [WorkPackageController::class, 'getTask'])->name('work-package.task.get');
Route::put('/work-package/task/{taskId}', [WorkPackageController::class, 'updateTask'])->name('work-package.task.update');
Route::post('/work-package/task/store', [WorkPackageController::class, 'storeTask'])->name('work-package.task.store');
Route::delete('/work-package/task/{taskId}', [WorkPackageController::class, 'deleteTask'])->name('work-package.task.delete');

// Work Package Volume Data Management
Route::put('/work-package/volume/{volume_id}/data', [WorkPackageController::class, 'updateVolumeData'])->name('work-package.volume.update-data');

// Manajemen Resource
Route::get('/resource-management', [ResourceManagementController::class, 'index'])->name('resource.management');
Route::post('/resource-management', [ResourceManagementController::class, 'store'])->name('resource.store');
Route::get('/resource-management/{id}/edit', [ResourceManagementController::class, 'edit'])->name('resource.edit');
Route::put('/resource-management/{id}', [ResourceManagementController::class, 'update'])->name('resource.update');

Route::get('/roles-management', [RolesManagementController::class, 'index'])->name('roles.management');