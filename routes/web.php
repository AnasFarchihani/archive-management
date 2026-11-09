<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\StorageLocationController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ArchiveFileController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Regular user control panel

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Archives
    Route::get('archives/trashed', [ArchiveController::class, 'trashed'])
        ->name('archives.trashed');
    Route::post('archives/{id}/restore', [ArchiveController::class, 'restore'])
        ->name('archives.restore');
    Route::resource('archives', ArchiveController::class);

    // Archive files
    Route::post('archives/{archive}/files', [ArchiveFileController::class, 'store'])
        ->name('archives.files.store');
    Route::get('files/{file}/download', [ArchiveFileController::class, 'download'])
        ->name('files.download');
    Route::delete('files/{file}', [ArchiveFileController::class, 'destroy'])
        ->name('files.destroy');
});

// Administrator Control Panel

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('users', UserController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('storage-locations', StorageLocationController::class);
    });
