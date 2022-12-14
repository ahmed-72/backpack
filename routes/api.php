<?php

use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\VendorsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//vendors
Route::resource('/vendor',VendorsController::class)->only('index','show','search');
Route::post('/search/vendor',[VendorsController::class,'search'])->name('vendor.search');

//products
Route::resource('/product',ProductsController::class)->only('index','show');
Route::post('/search/product',[ProductsController::class,'search'])->name('product.search');

//categoris
//Route::resource('/category',CategoriesController::class)->only('show');
Route::get('/category/vendor',[CategoriesController::class,'vendors_index'])->name('category.vendors_index');
Route::get('/category/product',[CategoriesController::class,'products_index'])->name('category.products_index');

