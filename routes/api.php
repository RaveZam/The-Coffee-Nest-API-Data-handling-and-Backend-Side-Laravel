<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\TestsController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('throttle:api')->group(function () {
    Route::get('/data', 'ApiController@getData');
});
    
Route::get('/products', [ProductController::class, 'calltable'])->name('product.call');
Route::get('/sales', [SalesController::class, 'callSales'])->name('sales.call');
Route::get('/sortedsales', [SalesController::class, 'callMostItemsSold'])->name('mostItemsSold.call');
Route::get('/countedcategory', [SalesController::class, 'callCountedCategory'])->name('countedCategory.call');
Route::get('/totalpriceperday', [SalesController::class, 'callTotalSalesAndDate'])->name('callTotalSalesAndDate.call');
Route::get('/previousmonthsales', [SalesController::class, 'previousTotalGrossAndQuantity'])->name('callPreviousMonthTotalSalesAndGross'); 
Route::post('/test', [TestsController::class, 'store'])->name('callTests');
Route::put('/products/update', [ProductController::class, 'update'])->name('updateProduct'); 
Route::post('/products/create', [ProductController::class, 'create'])->name('createProduct'); 