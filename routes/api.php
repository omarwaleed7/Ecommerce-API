<?php

use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\ProductReviewController;
use App\Http\Controllers\api\VoucherController;
use App\Http\Controllers\api\WishlistController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });
});

Route::controller(ProductController::class)->group(function(){
   Route::post('product/create','store')->name('product.create');
   Route::get('products','index')->name('products');
   Route::get('product/{id}','show')->name('product');
   Route::post('product/update','update')->name('product.update');
   Route::post('product/delete','delete')->name('product.delete');
});

Route::controller(CategoryController::class)->group(function(){
    Route::post('category/create','store')->name('category.create');
    Route::get('categories','index')->name('categories');
    Route::get('category/{id}','show')->name('category');
    Route::post('category/update','update')->name('category.update');
    Route::post('category/delete','delete')->name('category.delete');
});

Route::controller(VoucherController::class)->group(function(){
    Route::post('voucher/create','store')->name('voucher.create');
    Route::get('vouchers','index')->name('vouchers');
    Route::get('voucher/{id}','show')->name('voucher');
    Route::post('voucher/update','update')->name('voucher.update');
    Route::post('voucher/delete','delete')->name('voucher.delete');
});

Route::controller(WishlistController::class)->group(function(){
    Route::post('wishlist/create','store')->name('wishlist.create');
    Route::get('wishlist','show')->name('wishlist');
    Route::post('wishlist/delete','delete')->name('wishlist.delete');
});

Route::controller(ProductReviewController::class)->group(function(){
    Route::post('productreview/create','store')->name('productreview.create');
    Route::get('productreviews','index')->name('productreviews');
    Route::get('productreview/{id}','show')->name('productreview');
    Route::post('productreview/update','update')->name('productreview.update');
    Route::post('productreview/delete','delete')->name('productreview.delete');
});

Route::controller(CartController::class)->group(function(){
    Route::post('cart/create','store')->name('cart.create');
    Route::get('cart/{id}','show')->name('cart_item');
    Route::get('cart','index')->name('cart_items');
    Route::delete('cart/delete/{id}','delete')->name('cart.delete');
});

Route::controller(OrderController::class)->group(function(){
    Route::post('order/create','store')->name('cart.create');
    Route::get('orders','show')->name('cart');
    Route::post('order/delete','delete')->name('cart.delete');
});
