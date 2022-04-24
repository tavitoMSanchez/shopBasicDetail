<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ShopController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
// Route::group(['middleware' => 'admin'], function () {

// });
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\ProductController::class, 'index'])->name('home');
Route::get('/homecar', [App\Http\Controllers\ProductController::class, 'indexcar'])->name('homecar');
Route::get('/car', [App\Http\Controllers\ProductController::class, 'table'])->name('car');
Route::get('/carrito', [App\Http\Controllers\ProductController::class, 'tablecar'])->name('carrito');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'tableProduct'])->name('products');
Route::get('/tableProductClient', [App\Http\Controllers\ProductController::class, 'tableProductClient'])->name('tableProductClient');
Route::get('deletecarproduct', [App\Http\Controllers\CarController::class,'delete'])->name('deletecarproduct');
Route::get('deleteproduct', [App\Http\Controllers\ProductController::class,'delete'])->name('deleteproduct');
Route::get('editProduct', [App\Http\Controllers\ProductController::class,'edit'])->name('editProduct');
Route::get('buyshop', [App\Http\Controllers\ShopController::class,'buyshop'])->name('buyshop');
Route::post('updateproduct', [App\Http\Controllers\ProductController::class,'updateproduct'])->name('updateproduct');
Route::resource('product', ProductController::class)->names('product');
Route::resource('invoiceadmin', InvoiceController::class)->names('invoiceadmin');
Route::resource('carproduct',CarController::class)->names('carproduct');
Route::get('/shops', [App\Http\Controllers\InvoiceController::class, 'tableInvoiceShops'])->name('shops');
Route::get('/invoices', [App\Http\Controllers\InvoiceController::class, 'tableInvoice'])->name('invoices');
Route::get('/invoiceShop', [App\Http\Controllers\InvoiceController::class, 'invoiceShop'])->name('invoiceShop');
Route::get('/invoiceShops', [App\Http\Controllers\InvoiceController::class, 'invoiceShops'])->name('invoiceShops');
Route::get('/clientInvoice', [App\Http\Controllers\InvoiceController::class, 'clientInvoice'])->name('clientInvoice');
Route::get('/dataClient', [App\Http\Controllers\InvoiceController::class, 'dataClient'])->name('dataClient');
Route::get('/clients', [App\Http\Controllers\InvoiceController::class, 'tableClient'])->name('clients');
Route::get('/client', [App\Http\Controllers\ClientController::class, 'index'])->name('clientindex');
Route::get('/tableShopClient', [App\Http\Controllers\ClientController::class, 'tableShopClient'])->name('tableShopClient');
Route::get('/tableInvoiceClient', [App\Http\Controllers\ClientController::class, 'tableInvoiceClient'])->name('tableInvoiceClient');
Route::get('/tableShowInvoiceClient', [App\Http\Controllers\ClientController::class, 'tableShowInvoiceClient'])->name('tableShowInvoiceClient');

