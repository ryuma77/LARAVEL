<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ChartOfAccountController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UomController;
use App\Http\Controllers\BusinessPartnerController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BinController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\GoodReceiptController;
use App\Http\Controllers\GoodReceiptDetailController;
use App\Http\Controllers\SalesOrderController;


Route::get('/', function () {
    return redirect('login');
});

Route::middleware(['auth', 'permission:role.manage'])
    ->prefix('roles')
    ->name('roles.')
    ->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
    });

Route::middleware(['auth', 'permission:user.manage'])
    ->prefix('users')
    ->name('users.')
    ->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/', [UserManagementController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserManagementController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

Route::middleware(['auth', 'permission:accounting.manage'])
    ->prefix('coa')
    ->name('coa.')
    ->group(function () {
        Route::get('/', [ChartOfAccountController::class, 'index'])->name('index');
        Route::get('/create', [ChartOfAccountController::class, 'create'])->name('create');
        Route::post('/', [ChartOfAccountController::class, 'store'])->name('store');
        Route::get('/{coa}/edit', [ChartOfAccountController::class, 'edit'])->name('edit');
        Route::put('/{coa}', [ChartOfAccountController::class, 'update'])->name('update');
        Route::delete('/{coa}', [ChartOfAccountController::class, 'destroy'])->name('destroy');
    });

Route::middleware(['auth', 'permission:inventory.manage'])
    ->prefix('product-category')
    ->name('product-category.')
    ->group(function () {

        Route::get('/', [ProductCategoryController::class, 'index'])->name('index');
        Route::get('/create', [ProductCategoryController::class, 'create'])->name('create');
        Route::post('/', [ProductCategoryController::class, 'store'])->name('store');

        Route::get('/{category}/edit', [ProductCategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [ProductCategoryController::class, 'update'])->name('update');

        Route::post('/{category}/accounting', [ProductCategoryController::class, 'updateAccounting'])
            ->name('accounting.update');
    });

Route::middleware(['auth', 'permission:inventory.manage'])
    ->prefix('products')
    ->name('products.')
    ->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::post('/{product}/accounting', [ProductController::class, 'updateAccounting'])->name('accounting.update');
    });

Route::middleware(['auth', 'permission:inventory.manage'])
    ->prefix('uom')
    ->name('uom.')
    ->group(function () {
        Route::get('/', [UomController::class, 'index'])->name('index');
        Route::get('/create', [UomController::class, 'create'])->name('create');
        Route::post('/', [UomController::class, 'store'])->name('store');
        Route::get('/{uom}/edit', [UomController::class, 'edit'])->name('edit');
        Route::put('/{uom}', [UomController::class, 'update'])->name('update');
        Route::post('/{uom}/conversion', [UomController::class, 'storeConversion'])->name('conversion.store');
        Route::delete('/{uom}', [UomController::class, 'destroy'])->name('destroy');
    });

Route::middleware(['auth', 'permission:user.manage'])
    ->prefix('business-partner')
    ->name('business-partner.')
    ->group(function () {

        // HEADER
        Route::get('/', [BusinessPartnerController::class, 'index'])->name('index');
        Route::get('/create', [BusinessPartnerController::class, 'create'])->name('create');
        Route::post('/', [BusinessPartnerController::class, 'store'])->name('store');
        Route::get('/{business_partner}/edit', [BusinessPartnerController::class, 'edit'])->name('edit');
        Route::put('/{business_partner}', [BusinessPartnerController::class, 'update'])->name('update');

        // CONTACT
        Route::post('/{business_partner}/contact', [BusinessPartnerController::class, 'storeContact'])
            ->name('contact.store');

        Route::delete('/contact/{contact}', [BusinessPartnerController::class, 'deleteContact'])
            ->name('contact.delete');

        // ADDRESS
        Route::post('/{business_partner}/address', [BusinessPartnerController::class, 'storeAddress'])
            ->name('address.store');

        Route::delete('/address/{address}', [BusinessPartnerController::class, 'deleteAddress'])
            ->name('address.delete');

        // ACCOUNTING
        Route::post('/{business_partner}/accounting', [BusinessPartnerController::class, 'updateAccounting'])
            ->name('accounting.update');
    });

Route::middleware(['auth', 'permission:inventory.manage'])
    ->prefix('warehouses')
    ->name('warehouses.')
    ->group(function () {

        // Warehouse header CRUD
        Route::get('/', [WarehouseController::class, 'index'])->name('index');
        Route::get('/create', [WarehouseController::class, 'create'])->name('create');
        Route::post('/', [WarehouseController::class, 'store'])->name('store');
        Route::get('/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('edit');
        Route::put('/{warehouse}', [WarehouseController::class, 'update'])->name('update');
        Route::delete('/{warehouse}', [WarehouseController::class, 'destroy'])->name('destroy');

        // Locations nested under warehouse
        Route::get('/{warehouse}/locations', [LocationController::class, 'index'])->name('locations.index');
        Route::get('/{warehouse}/locations/create', [LocationController::class, 'create'])->name('locations.create');
        Route::post('/{warehouse}/locations', [LocationController::class, 'store'])->name('locations.store');
        Route::get('/{warehouse}/locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
        Route::put('/{warehouse}/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
        Route::delete('/{warehouse}/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');

        // Bins nested under location
        Route::post('/{warehouse}/locations/{location}/bins', [BinController::class, 'store'])->name('bins.store');
        Route::get('/{warehouse}/locations/{location}/bins/{bin}/edit', [BinController::class, 'edit'])->name('bins.edit');
        Route::put('/{warehouse}/locations/{location}/bins/{bin}', [BinController::class, 'update'])->name('bins.update');
        Route::delete('/{warehouse}/locations/{location}/bins/{bin}', [BinController::class, 'destroy'])->name('bins.destroy');
    });

Route::middleware(['auth', 'permission:purchase.manage'])
    ->prefix('po')
    ->name('po.')
    ->group(function () {

        Route::get('/', [PurchaseOrderController::class, 'index'])->name('index');
        Route::get('/create', [PurchaseOrderController::class, 'create'])->name('create');
        Route::post('/', [PurchaseOrderController::class, 'store'])->name('store');
        Route::get('/{po}/edit', [PurchaseOrderController::class, 'edit'])->name('edit');
        Route::put('/{po}', [PurchaseOrderController::class, 'update'])->name('update');
        Route::post('/{po}/details', [PurchaseOrderController::class, 'storeDetail'])->name('details.store');
    });

// GOOD RECEIPT
Route::prefix('good-receipt')->name('good-receipt.')->group(function () {

    Route::get('/', [GoodReceiptController::class, 'index'])->name('index');
    Route::get('/create', [GoodReceiptController::class, 'create'])->name('create');
    Route::post('/', [GoodReceiptController::class, 'store'])->name('store');

    // Single-page edit
    Route::get('/{id}/edit', [GoodReceiptController::class, 'edit'])->name('edit');
    Route::post('/{id}/add-detail', [GoodReceiptController::class, 'addDetail'])->name('add-detail');
    Route::delete('/detail/{detail}', [GoodReceiptController::class, 'deleteDetail'])->name('delete-detail');
});

Route::middleware(['auth', 'permission:sales.manage'])
    ->prefix('sales-order')
    ->name('sales-order.')
    ->group(function () {

        Route::get('/', [SalesOrderController::class, 'index'])->name('index');
        Route::get('/create', [SalesOrderController::class, 'create'])->name('create');
        Route::post('/', [SalesOrderController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SalesOrderController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SalesOrderController::class, 'update'])->name('update');

        // DETAILS
        Route::post('/{id}/details', [SalesOrderController::class, 'addDetail'])->name('details.add');
        Route::delete('/{soId}/details/{detailId}', [SalesOrderController::class, 'deleteDetail'])->name('details.delete');
    });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test-permission', function () {
    return 'permission OK';
})->middleware('permission:inventory.view');


require __DIR__ . '/auth.php';
