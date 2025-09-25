<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardKaryawanController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\PerformanceTaskController;
use App\Http\Controllers\PerformanceFinanceController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\WorkPackageController;
use App\Http\Controllers\ResourceManagementController;
use App\Http\Controllers\RolesManagementController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\TimesheetManagementController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\WPCategoryManagementController;
use App\Http\Controllers\WorkPackageManagementController;
use App\Http\Controllers\WOContentListController;
use App\Http\Controllers\WorkOrderManagementController;
use App\Http\Controllers\WorkPackagesListController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test', function () {
//     return view('test');
// });

Route::middleware(['auth', 'role:admin'])->group(function(){
    // Manajemen Work Package
    Route::get('/wp-management', [WorkPackageManagementController::class, 'index'])->name('wp-management');
    Route::post('/wp-management', [WorkPackageManagementController::class, 'store'])->name('wp-management.store');
    Route::get('/wp-management/detail/{wp_id}', [WorkPackageManagementController::class, 'detail'])->name('wp-management.detail');
    Route::get('/wp-management/{wp_id}/edit', [WorkPackageManagementController::class, 'edit'])->name('wp-management.edit');
    Route::put('/wp-management/{wp_id}', [WorkPackageManagementController::class, 'update'])->name('wp-management.update');
    Route::get('/wp-management/users-with-roles', [WorkPackageManagementController::class, 'getUsersWithRoles'])->name('wp-management.users-with-roles');
    Route::get('/wp-management/next-wp-number', [WorkPackageManagementController::class, 'getNextWpNumber'])->name('wp-management.next-wp-number');
    Route::get('/wp-management/check-wp-number', [WorkPackageManagementController::class, 'checkWpNumberAvailability'])->name('wp-management.check-wp-number');
    Route::get('/wp-management/{wp_id}/check-associations', [WorkPackageManagementController::class, 'checkWorkPackageAssociations'])->name('wp-management.check-wp-associations');
    Route::delete('/wp-management/{wp_id}/force-delete', [WorkPackageManagementController::class, 'forceDeleteWorkPackage'])->name('wp-management.force-delete-wp');
    Route::get('/wp-management/check-role-assignments', [WorkPackageManagementController::class, 'checkRoleAssignments'])->name('wp-management.check-role-assignments');

    // manajemen kategori work package
    Route::get('/wpcategory-management', [WPCategoryManagementController::class, 'index'])->name('wpcategory.management');
    Route::post('/wpcategory-management/add', [WPCategoryManagementController::class, 'add'])->name('wpcategory.add');
    Route::put('/wpcategory-management/edit', [WPCategoryManagementController::class, 'edit'])->name('wpcategory.edit');
    Route::delete('/wpcategory-management/{id}/delete', [WPCategoryManagementController::class, 'delete'])->name('wpcategory.delete');

    // Manajemen Resource
    Route::get('/resource-management', [ResourceManagementController::class, 'index'])->name('resource.management');
    Route::post('/resource-management', [ResourceManagementController::class, 'store'])->name('resource.store');
    Route::get('/resource-management/{id}/edit', [ResourceManagementController::class, 'edit'])->name('resource.edit');
    Route::put('/resource-management/{id}', [ResourceManagementController::class, 'update'])->name('resource.update');

    // Manajemen Roles
    Route::get('/roles-management', [RolesManagementController::class, 'index'])->name('roles.management');
    Route::post('/roles-management', [RolesManagementController::class, 'store'])->name('roles.store');
    Route::get('/roles-management/{id}/edit', [RolesManagementController::class, 'edit'])->name('roles.edit');
    Route::put('/roles-management/{id}', [RolesManagementController::class, 'update'])->name('roles.update');
    Route::delete('/roles-management/{id}', [RolesManagementController::class, 'destroy'])->name('roles.destroy');

    // Manajemen Timesheet
    Route::get('/timesheet-management', [TimesheetManagementController::class, 'index'])->name('timesheet.management');
    Route::post('/timesheet-management/add', [TimesheetManagementController::class, 'add'])->name('timesheet.add');
    Route::get('/timesheet-management/{volume_id}/{execution_date}/edit-data', [TimesheetManagementController::class, 'editData'])->name('timesheet.edit.data');
    Route::post('/timesheet-management/edit', [TimesheetManagementController::class, 'edit'])->name('timesheet.edit');
    Route::delete('/timesheet-management/{id}/delete-all', [TimesheetManagementController::class, 'deleteAll'])->name('timesheet.delete.all');
    Route::delete('/timesheet-management/{id}/delete', [TimesheetManagementController::class, 'delete'])->name('timesheet.delete');

    // performance task
    Route::post('/performance-task/sub-task', [PerformanceTaskController::class, 'storeSubTask'])->name('performance-task.sub-task.store');
    Route::get('/performance-task/task/{taskId}/info', [PerformanceTaskController::class, 'getTaskForSubTask'])->name('performance-task.task.info');
    Route::get('/performance-task/sub-task/{subTaskId}/edit', [PerformanceTaskController::class, 'editSubTask'])->name('performance-task.sub-task.edit');
    Route::put('/performance-task/sub-task/{subTaskId}', [PerformanceTaskController::class, 'updateSubTask'])->name('performance-task.sub-task.update');
    Route::delete('/performance-task/sub-task/{id}', [PerformanceTaskController::class, 'destroySubTask'])->name('performance-task.sub-task.destroy');

    // performance finance
    Route::put('/performance-finance', [PerformanceFinanceController::class, 'edit'])->name('performance-finance.edit');

    // work package volume page
    Route::put('/work-package/volume/{volume_id}/data', [WorkPackageController::class, 'updateVolumeData'])->name('work-package.volume.update-data');

    Route::get('/work-package/task/{taskId}', [WorkPackageController::class, 'getTask'])->name('work-package.task.get');
    Route::put('/work-package/task/{taskId}', [WorkPackageController::class, 'updateTask'])->name('work-package.task.update');
    Route::post('/work-package/task/store', [WorkPackageController::class, 'storeTask'])->name('work-package.task.store');
    Route::delete('/work-package/task/{taskId}', [WorkPackageController::class, 'deleteTask'])->name('work-package.task.delete');
    Route::get('/work-package/task/{taskId}/subtask-count', [WorkPackageController::class, 'getSubTaskCount'])->name('work-package.task.subtask.count');

    Route::get('/work-package/subtask/{subTaskId}', [WorkPackageController::class, 'getSubTask'])->name('work-package.subtask.get');
    Route::post('/work-package/subtask/store', [WorkPackageController::class, 'storeSubTask'])->name('work-package.subtask.store');
    Route::delete('/work-package/subtask/{subTaskId}', [WorkPackageController::class, 'deleteSubTask'])->name('work-package.subtask.delete');
    Route::put('/work-package/subtask/{subTaskId}', [WorkPackageController::class, 'updateSubTask'])->name('work-package.subtask.update');

    // work order
    Route::get('/work-order', [WorkOrderManagementController::class, 'index'])->name('work-order');
    Route::post('/work-order/add', [WorkOrderManagementController::class, 'add'])->name('work-order.add');
    Route::put('/work-order/assign', [WorkOrderManagementController::class, 'assign'])->name('work-order.assign');
    Route::put('/work-order/update', [WorkOrderManagementController::class, 'updateWO'])->name('work-order.update');
});

Route::middleware(['auth', 'role:admin|karyawan'])->group(function(){
    // general
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', function () {
        // Redirect ke halaman sebelumnya jika akses via GET
        return redirect()->back();
    });
    Route::get('/profile', [ProfileUserController::class, 'index'])->name('profile');
    Route::put('/profile/{userId}', [ProfileUserController::class, 'edit'])->name('profile.edit');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // performance task
    Route::get('/performance-task', [PerformanceTaskController::class, 'index'])->name('performance-task');
    Route::get('/performance-task/{volume_id}', [PerformanceTaskController::class, 'detail'])->name('performance-task.detail');

    // performance finance
    Route::get('/performance-finance', [PerformanceFinanceController::class, 'index'])->name('performance-finance');
    Route::get('/performance-finance/{volume_id}', [PerformanceFinanceController::class, 'detail'])->name('performance-finance.detail');

    // timesheet summary
    Route::get('/timesheet', [TimesheetController::class, 'index'])->name('timesheet');
    Route::get('/timesheet/{volume_id?}', [TimesheetController::class, 'detail'])->name('timesheet.detail');

    // work package volume page
    Route::get('/work-package', [WorkPackageController::class, 'index'])->name('work-package');
    Route::get('/work-package/{volume_id}', [WorkPackageController::class, 'detail'])->name('work-package.detail');

    Route::get('/work-order/{wo_id}/content', [WOContentListController::class, 'index'])->name('wo.content-list');

    // work packages list
    Route::get('/workpackages-list', [WorkPackagesListController::class, 'index'])->name('workpackages-list');
});

Route::middleware(['auth', 'role:karyawan'])->group(function(){
    // dashboard karyawan
    Route::get('/dashboard-karyawan/{user_id}', [DashboardKaryawanController::class, 'index'])->name('dashboard-karyawan');

    // timesheet activity per user
    Route::get('/timesheet-user/{volume_id}/{user_id}', [TimesheetController::class, 'detailperUser'])->name('timesheet.detail.user');
    Route::post('/timesheet-user/{volume_id}/{user_id}/add', [TimesheetController::class, 'addperUser'])->name('timesheet.user.add');
    Route::put('/timesheet-user/{volume_id}/{user_id}/edit', [TimesheetController::class, 'editperUser'])->name('timesheet.user.edit');
    Route::delete('/timesheet-user/{timesheet_id}/delete', [TimesheetController::class, 'deleteperUser'])->name('timesheet.user.delete');

});

// login routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.confirm');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('/perencanaan', [PerencanaanController::class, 'index'])->name('perencanaan');
Route::get('/realisasi', [RealisasiController::class, 'index'])->name('realisasi');
Route::get('/kanban', [KanbanController::class, 'index'])->name('kanban');
Route::get('/task', [TaskController::class, 'index'])->name('task');
