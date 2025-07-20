<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\SupplierController;
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
        Route::prefix('barang')->group(function () {
            Route::post('import', [BarangController::class, 'import'])->name('barang.import');
            Route::get('view-import', [BarangController::class, 'importView'])->name('barang.import.view');
        });
    });

    // Permission supplier
    Route::middleware(['can:module_supplier'])->group(function () {
        Route::resources([
            'supplier' => SupplierController::class
        ]);
    });

    // permission barang masuk
    Route::middleware(['can:module_barangmasuk'])->group(function () {
        Route::prefix('barang-masuk')->group(function () {
            Route::post('/', [BarangMasukController::class, 'store'])->name('barang-masuk.store');
            Route::get('index', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
            Route::get('get-harga-barang', [BarangMasukController::class, 'getHargaBarang'])->name('barang-masuk.gethargabarang');
            Route::get('get-detail-barang', [BarangMasukController::class, 'getDetailBarang'])->name('barang-masuk.getdetailbarang');
        });
    });

    Route::middleware(['can:module_purchaseorder'])->group(function () {
        Route::prefix('purchase-order')->group(function () {
            Route::get('/', [PurchaseOrderController::class, 'index'])->name('purchase-order.index');
            Route::get('/create', [PurchaseOrderController::class, 'create'])->name('purchase-order.create');
            Route::post('/store', [PurchaseOrderController::class, 'store'])->name('purchase-order.store');
            Route::get('/{id}', [PurchaseOrderController::class, 'show'])->name('purchase-order.show');
            Route::post('/add/po-payment',[PurchaseOrderController::class, 'storepopayment'])->name('purchase-order.store.po-payment');
        });
    });
});
