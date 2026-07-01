<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('companies', CompanyController::class)->except('show');
    Route::resource('branches', BranchController::class)->except('show');
    Route::resource('users', UserController::class)->except('show');
    Route::resource('customers', CustomerController::class)->except('show');
    Route::resource('products', ProductController::class)->except('show');
    Route::resource('quotes', QuoteController::class)->except('show');
    Route::resource('sales', SaleController::class)->except('show');
    Route::resource('service-orders', ServiceOrderController::class)->except('show');
});

require __DIR__.'/auth.php';
