<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StockController;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Supplier;
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

// Route::get('/', function () {
//     return view('login');
// });


Route::get('/', [LoginController::class, 'login'])->name('login');
// Route::get('/home', [MahasiswaController::class, 'index'])->name('home')->middleware('auth');
Route::post('/actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

Route::post('/actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

Route::middleware(['auth'])->group(function(){
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
        $products = Product::with(['category', 'supplier'])->orderBy('id', 'desc')->get();
        $data = [
            'products' => $products
        ];

        $pdf = Pdf::loadview('pdf.products_pdf', $data);
        return $pdf->download('laporan-pegawai-pdf.pdf');
    });

    Route::get('/categories_pdf', function() {
        $categories = Category::orderBy('id', 'desc')->get();
        $data = [
            'categories' => $categories
        ];

        $pdf = Pdf::loadview('pdf.category', $data);
        return $pdf->download('laporan-category-pdf.pdf');
    });

    Route::get('/supplier_pdf', function() {
        $supplier = Supplier::orderBy('id', 'desc')->get();
        $data = [
            'supplier' => $supplier
        ];

        $pdf = Pdf::loadview('pdf.supplier', $data);
        return $pdf->download('laporan-supplier-pdf.pdf');
    });

    Route::get('/transaction_pdf/{product_id}/{nama_product}', function($product_id, $nama_product) {
        $transaction = Stock::where('product_id', $product_id)->get();
        $data = [
            'transaction' => $transaction,
            'nama_product' => $nama_product
        ];

        $pdf = Pdf::loadview('pdf.transaction', $data);
        return $pdf->download('laporan-transaction-pdf.pdf');
    });
});