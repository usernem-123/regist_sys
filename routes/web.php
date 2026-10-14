
<?php

use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\SuperAdmin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\RolePermissionController;

Route::inertia('/', 'dashboard')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth', 'verified', 'superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {
        Route::get('/', [SuperAdminController::class, 'index'])
            ->name('dashboard');

        Route::resource('users', UserController::class)
            ->except(['show', 'destroy']);

        Route::patch('users/{user}/toggle-active', [
            UserController::class,
            'toggleActive',
        ])->name('users.toggle-active');

        Route::get('permissions', [
            RolePermissionController::class,
            'index',
        ])->name('permissions.index');

        Route::patch('roles/{role}/permissions/{permission}', [
            RolePermissionController::class,
            'toggle',
        ])->name('roles.permissions.toggle');
    });

require __DIR__.'/settings.php';
