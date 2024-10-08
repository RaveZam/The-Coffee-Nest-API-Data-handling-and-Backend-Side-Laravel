<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, 'calltable'])->name('product.call');
Route::get('/sales', [SalesController::class, 'callSales'])->name('sales.call');
Route::get('/sortedsales', [SalesController::class, 'callMostItemsSold'])->name('mostItemsSold.call');
Route::get('/countedcategory', [SalesController::class, 'callCountedCategory'])->name('countedCategory.call');
Route::get('/totalpriceperday', [SalesController::class, 'callTotalSalesAndDate'])->name('callTotalSalesAndDate.call');