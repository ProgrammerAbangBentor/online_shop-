<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Shop\ProductCatalogController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('pages.auth.login');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard admin
    Route::get('/home', [DashboardController::class, 'index'])->name('pages.dashboard');

    // Master Data
    Route::resource('user', UserController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);

    Route::get('/laporan', [ReportController::class, 'index'])
    ->name('laporan.index');

    Route::get('/laporan/export/excel', [ReportController::class, 'exportExcel'])->name('laporan.export.excel');
    Route::get('/laporan/export/pdf',   [ReportController::class, 'exportPdf'])->name('laporan.export.pdf');
});


/*
|--------------------------------------------------------------------------
| USER / PELANGGAN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('shop')->group(function () {

    Route::get('/dashboard', [ProductCatalogController::class, 'dashboard'])
        ->name('shop.dashboard');

    // Katalog Produk (untuk pelanggan)
    Route::get('/products', [ProductCatalogController::class, 'index'])
        ->name('shop.products.index');

    // Detail Produk
    Route::get('/products/{id}', [ProductCatalogController::class, 'show'])
        ->name('shop.products.show');

    Route::get('/pelanggan', [CustomerController::class, 'index'])
            ->name('customers.index');


    Route::get('/cart', [CartController::class, 'index'])
        ->name('shop.cart.index');
    Route::post('/cart/add/{productId}', [CartController::class, 'add'])
        ->name('cart.add');
    Route::post('/cart/item/{itemId}/qty', [CartController::class, 'updateQty'])
        ->name('cart.item.qty');
    Route::delete('/cart/item/{itemId}', [CartController::class, 'remove'])
        ->name('cart.item.remove');
});



Route::middleware('auth')->group(function () {

  Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
  Route::get('/transactions/checkout', [TransactionController::class, 'checkout'])->name('transactions.checkout');
  Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

  // ✅ taruh finish duluan
  Route::get('/transactions/finish', [TransactionController::class, 'finish'])->name('transactions.finish');

  // baru route parameter
  Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
});

// webhook/callback midtrans (lebih bagus TANPA auth)
Route::post('/midtrans/callback', [TransactionController::class, 'midtransCallback'])->name('midtrans.callback');
