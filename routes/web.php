<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::middleware(['can:manage-users'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    });
});

require __DIR__ . '/auth.php';
Route::resource('categories', CategoryController::class);

// Route untuk manajemen produk
Route::resource('products', ProductController::class);
// Route::get('/products', [ProductController::class, 'index'])->name('products');
// Route tambahan untuk update stok
Route::post('/products/{product}/update-stock', [ProductController::class, 'updateStock'])
    ->name('products.updateStock');



Route::resource('suppliers', SupplierController::class);
Route::resource('purchases', PurchaseController::class);

Route::resource('sales', SaleController::class);
Route::get('/products/{product}/get', [SaleController::class, 'getProduct'])->name('products.get');
Route::get('sales/{sale}/invoice', [SaleController::class, 'invoice'])->name('sales.invoice');


Route::resource('customers', CustomerController::class);
Route::get('customers-search', [CustomerController::class, 'search'])->name('customers.search');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
Route::get('/reports/profit-loss', [ReportController::class, 'profitLoss'])->name('reports.profit-loss');
Route::get('/reports/export/sales', [ReportController::class, 'exportSales'])->name('reports.export.sales');
