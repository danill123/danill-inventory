<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\StockController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

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
Route::resource('stocks', StockController::class);


Route::get('/products', function () {
    $products = Product::all();
    return view('products', compact('products'));
});

Route::get('/categories', function() {
    return view('categories');
});

Route::get('/supplier', function() {
    return view('supplier');
});

Route::get('/products_pdf', function() {
    // ProductResource::collection($products)
    $products = Product::with(['category', 'supplier'])->orderBy('id', 'desc')->get();
    $data = [
        'products' => $products
    ];

    // var_dump("<pre>");
    // var_dump($data);
    // exit;

    $pdf = Pdf::loadview('pdf.products_pdf', $data);
    return $pdf->download('laporan-pegawai-pdf.pdf');
});