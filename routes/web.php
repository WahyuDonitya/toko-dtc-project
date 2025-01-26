<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::get('login', function () {
    return view('login');
})->name('login');

Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');


Route::prefix('authenticate')->group(function () {
    Route::post('login', [SiteController::class, 'dologin'])->name('login.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Permission Users Privilage
    Route::middleware(['can:module_settinguserprivilage'])->group(function () {
        Route::post('users/update-permissions', [UserController::class, 'updatepermission'])->name('users.updatepermission');
        Route::resources([
            'users' => UserController::class,
        ]);
    });


    // Permission barang
    Route::middleware(['can:module_barang'])->group(function () {
        Route::resources([
            'barangs' => BarangController::class
        ]);
    });
});
