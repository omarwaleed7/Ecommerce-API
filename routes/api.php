<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CartItemController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\Api\FilterAndSortController;
use App\Http\Controllers\api\FilterController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\ProductReviewController;
use App\Http\Controllers\api\SearchController;
use App\Http\Controllers\api\SortController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\VoucherController;
use App\Http\Controllers\api\WishlistItemController;
use App\Http\Controllers\api\PaymentController;
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
    Route::post('register', 'register')->name('auth.register');

    // User login
    Route::post('login', 'login')->name('auth.login');

    // Routes below are protected by the 'sanctum' middleware
    Route::middleware('auth:sanctum')->group(function () {

        // Fetch authenticated user details
        Route::get('user', 'user')->name('auth.user');

        // Refresh authentication token
        Route::post('refresh', 'refresh')->name('auth.refresh');

        // User logout
        Route::post('logout', 'logout')->name('auth.logout');
    });
});

// Products routes

Route::prefix('products')->controller(ProductController::class)->group(function () {

    // Fetch all products
    Route::get('/', 'index')->name('products.index');

    // Fetch details of a specific product by ID
    Route::get('{id}', 'show')->name('products.show');

    // Create a new product
    Route::post('/', 'store')->middleware(['auth:sanctum', 'check_admin'])->name('products.store');

    // Update a product by ID
    Route::patch('{id}', 'update')->middleware(['auth:sanctum', 'check_admin'])->name('products.update');

    // Delete a product by ID
    Route::delete('{id}', 'destroy')->middleware(['auth:sanctum', 'check_admin'])->name('products.destroy');
});

// Categories routes

Route::prefix('categories')->controller(CategoryController::class)->group(function () {

    // Fetch all categories
    Route::get('', 'index')->name('categories.index');

    // Fetch details of a specific category by ID
    Route::get('{id}', 'show')->name('categories.show');

    // Create a new category
    Route::post('/', 'store')->middleware(['auth:sanctum', 'check_admin'])->name('categories.store');

    // Update a category by ID
    Route::patch('{id}', 'update')->middleware(['auth:sanctum', 'check_admin'])->name('categories.update');

    // Delete a category by ID
    Route::delete('{id}', 'destroy')->middleware(['auth:sanctum', 'check_admin'])->name('categories.destroy');
});


// Vouchers routes

Route::prefix('vouchers')->controller(VoucherController::class)->group(function () {

    // Fetch all vouchers
    Route::get('/', 'index')->name('vouchers.index');

    // Fetch details of a specific voucher by ID
    Route::get('{id}', 'show')->name('vouchers.show');

    // Create a new voucher
    Route::post('/', 'store')->middleware(['auth:sanctum', 'check_admin'])->name('vouchers.store');

    // Update a voucher by ID
    Route::patch('{id}', 'update')->middleware(['auth:sanctum', 'check_admin'])->name('voucher.update');

    // Delete a voucher by ID
    Route::delete('{id}', 'destroy')->middleware(['auth:sanctum', 'check_admin'])->name('vouchers.destroy');
});


// WishlistItem routes

Route::prefix('wishlistitems')->middleware('auth:sanctum')->controller(WishlistItemController::class)->group(function () {

    // Show wishlist
    Route::get('/', 'index')->name('wishlist.index');

    // Fetch details of a specific wishlist item by ID
    Route::get('{id}', 'show')->name('wishlist.show');

    // Create a new item in wishlist
    Route::post('/', 'store')->name('wishlist.store');

    // Delete a item in wishlist by ID
    Route::delete('{id}', 'destroy')->middleware('check_ownership:App\\Models\\WishlistItem,id')->name('wishlist.delete');
});

// Product reviews routes

Route::prefix('productreviews')->controller(ProductReviewController::class)->group(function () {

    // Fetch all product reviews for a specific product
    Route::get('product/{product_id}', 'index')->name('productreviews.index');

    // Fetch details of a specific product review by ID
    Route::get('review/{id}', 'show')->name('productreviews.show');

    // Create a new product review
    Route::post('/', 'store')->middleware('auth:sanctum')->name('productreviews.store');

    // Update a product review by ID
    Route::patch('review/{id}', 'update')->middleware(['auth:sanctum', 'check_ownership:App\\Models\\ProductReview,id'])->name('productreviews.update');

    // Delete a product review by ID
    Route::delete('review/{id}', 'destroy')->middleware(['auth:sanctum', 'check_ownership:App\\Models\\ProductReview,id'])->name('productreviews.destroy');
});


// CartItem routes

Route::prefix('cart')->middleware('auth:sanctum')->controller(CartItemController::class)->group(function () {

    // Fetch all cart items
    Route::get('/', 'index')->name('cart.index');

    // Show a specific cart item by ID
    Route::get('{id}', 'show')->name('cart.show');

    // Create a new cart item
    Route::post('/', 'store')->name('cart.store');

    // Delete a specific cart item by ID
    Route::delete('{id}', 'destroy')->middleware('check_ownership:App\\Models\\CartItem,id')->name('carts.destroy');
});


// Order routes

Route::prefix('orders')->middleware('auth:sanctum')->controller(OrderController::class)->group(function () {

    // Fetch all orders
    Route::get('/', 'index')->name('orders.index');

    // Show an order
    Route::get('{id}', 'show')->name('orders.show');

    // Create a new order
    Route::post('/', 'store')->name('orders.create');
});

// Filter routes
Route::prefix('filter')->controller(FilterController::class)->group(function () {
    // Filter products by price
    Route::post('price','filterByPrice')->name('filter.price');

    // Filter products by category
    Route::get('category/{id}','filterByCategory')->name('filter.category');
});

// Sort routes
Route::prefix('sort')->controller(SortController::class)->group(function () {

    // Sort products by name
    Route::get('name','sortByName')->name('sort.category');

    // Sort products by price
    Route::get('price','sortByPrice')->name('sort.price');

    // Sort products by price in descending order
    Route::get('price_desc','sortByPriceDesc')->name('sort.price_desc');

    // Sort products by date
    Route::get('date','sortByDate')->name('sort.date');

    // Sort products by date in descending order
    Route::get('date_desc','sortByDateDesc')->name('sort.date_desc');

    // Sort products by popularity
    Route::get('popularity','sortByPopularity')->name('sort.popularity');
});

// Search routes
Route::prefix('search')->controller(SearchController::class)->group(function () {

    // Search products by name
    Route::post('','search')->name('search.search_query');
});

// Filter and Sort routes
Route::prefix('filterandsort')->controller(FilterAndSortController::class)->group(function () {
    // Filter and sort products
    Route::post('/','filterAndSort')->name('filterandsort.index');
});

// User profile routes
Route::prefix('profile')->middleware('auth:sanctum')->controller(UserController::class)->group(function () {

    // Update user profile
    Route::patch('/', 'updateProfile')->name('profile.update');

    // Delete user profile
    Route::post('/', 'deleteProfile')->name('profile.delete');
});
