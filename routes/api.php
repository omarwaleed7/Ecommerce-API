<?php

use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\ProductReviewController;
use App\Http\Controllers\api\VoucherController;
use App\Http\Controllers\api\WishlistController;
use App\Http\Controllers\AuthController;
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

// Authentication routes

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    // User registration
    Route::post('register','register')->name('auth.register');

    // User login
    Route::post('login','login')->name('auth.login');

    // Routes below are protected by the 'sanctum' middleware
    Route::middleware('auth:sanctum')->group(function() {

        // Fetch authenticated user details
        Route::get('user', 'user')->name('auth.user');

        // Refresh authentication token
        Route::post('refresh','refresh')->name('auth.refresh');

        // User logout
        Route::post('logout', 'logout')->name('auth.logout');
    });
});

// Products routes

Route::prefix('categories')->controller(CategoryController::class)->group(function(){

    // Fetch all categories
    Route::get('/', 'index')->name('categories.index');

    // Fetch details of a specific category by ID
    Route::get('{id}', 'show')->name('categories.show');

    // Create a new category
    Route::post('/', 'store')->middleware('auth:sanctum')->name('categories.store');

    // Update a category by ID
    Route::put('{id}', 'update')->middleware(['auth:api','owner'])->name('categories.update');

    // Delete a category by ID
    Route::delete('{id}', 'destroy')->middleware(['auth:api','owner'])->name('categories.destroy');
});

// Products routes

Route::prefix('categories')->controller(CategoryController::class)->group(function(){

    // Fetch all categories
    Route::get('','index')->name('categories.index');

    // Fetch details of a specific category by ID
    Route::get('{id}','show')->name('categories.show');

    // Create a new category
    Route::post('/','store')->middleware('auth:sanctum')->name('categories.store');

    // Update a category by ID
    Route::patch('{id}','update')->middleware(['auth:api','owner'])->name('categories.update');

    // Delete a category by ID
    Route::delete('{id}','destroy')->middleware(['auth:api','owner'])->name('categories.destroy');
});


// Vouchers routes

Route::prefix('vouchers')->controller(VoucherController::class)->group(function(){

    // Fetch all vouchers
    Route::get('/','index')->name('vouchers.index');

    // Fetch details of a specific voucher by ID
    Route::get('{id}','show')->name('vouchers.show');

    // Create a new voucher
    Route::post('/','store')->middleware('auth:sanctum')->name('vouchers.store');

    // Update a voucher by ID
    Route::patch('{id}','update')->middleware(['auth:api','owner'])->name('voucher.update');

    // Delete a voucher by ID
    Route::delete('{id}','destroy')->middleware(['auth:api','owner'])->name('vouchers.destroy');
});


// Wishlist routes

Route::prefix('wishlist')->middleware('auth:sanctum')->controller(WishlistController::class)->group(function(){

    // Show wishlist
    Route::get('/','index')->name('wishlist.index');

    // Create a new item in wishlist
    Route::post('/','store')->name('wishlist.store');

    // Delete a item in wishlist by ID
    Route::delete('{id}','destroy')->middleware('owner')->name('wishlist.delete');
});


// Product reviews routes

Route::prefix('productreviews')->controller(ProductReviewController::class)->group(function(){

    // Fetch details of a specific product review by ID
    Route::get('{id}','show')->name('productreview.show');

    // Create a new product review
    Route::post('/','store')->name('productreviews.store');

    // Update a product review by ID
    Route::patch('{id}','update')->middleware(['auth:sanctum','owner'])->name('productreview.update');

    // Delete a product review by ID
    Route::delete('{id}','destroy')->middleware(['auth:sanctum','owner'])->name('productreview.destroy');
});

// Cart routes

Route::prefix('cart')->middleware('auth:sanctum')->controller(CartController::class)->group(function(){

    // Show a specific cart item by ID
    Route::get('{id}','show')->name('cart.show');

    // Fetch all cart items
    Route::get('/','index')->name('cart.index');

    // Create a new cart item
    Route::post('/','store')->name('cart.store');

    // Delete a specific cart item by ID
    Route::delete('{id}','destroy')->middleware('owner')->name('cart.destroy');
});


// Order routes

Route::prefix('order')->middleware('auth:sanctum')->controller(OrderController::class)->group(function(){

    // Show an order
    Route::get('/','show')->name('order.show');

    // Create a new order
    Route::post('/','store')->name('order.create');

    // Delete an order by ID
    Route::delete('{id}','destroy')->middleware('owner')->name('order.destroy');
});
