<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SupplierController;

// use App\Http\Controllers\Inventory;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::apiResource('api/products', ProductController::class);
Route::apiResource('api/categories', CategoryController::class);
Route::apiResource('api/suppliers', SupplierController::class);


Route::get('/', function () {
    return view('products');
});

Route::get('/categories', function() {
    return view('categories');
});

Route::get('/supplier', function() {
    return view('supplier');
});
