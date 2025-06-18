<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\WishlistController;

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

Route::get('/', function () {
    return view('welcome');
});

 Route::get('/dashboard', function () {
   return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('backend')->group(function () {
        Route::get('/adm', function () {
            return view('admin.dashboard');
        })->middleware('role:super-admin|admin');

        Route::middleware('role:super-admin|admin')->group(function () {
            Route::get('/products', [ProductController::class, 'index'])->name('products.index');
            Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('products/create', [ProductController::class, 'store'])->name('products.store');
            Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
            Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
            Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');

            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('users/create', [UserController::class, 'store'])->name('users.store');
            Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
            
            Route::resource('categories', CategoryController::class);

        });
        
        Route::middleware('role:super-admin')->group(function () {
            Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
            Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::resource('roles', RoleController::class);
        });
    })->middleware('role:super-admin|admin');


    Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/wishlist/wishlisttocart', [WishlistController::class, 'wishlisttocart'])->name('wishlist.wishlisttocart');
});
Route::get('/products', [ProductController::class, 'index'])->name('products.productlist');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
//Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');

require __DIR__.'/auth.php';
