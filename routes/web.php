<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\DocumentationController;

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
Route::get('/documentation', [DocumentationController::class, 'index'])->name('documentation');