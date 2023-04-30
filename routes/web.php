<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartProductController;
use App\Http\Controllers\IndexController;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Middleware\IsAdmin;


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
    return view('main.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
}); 
Route::middleware(['is_admin','add.created_by'])->group(function () {
    Route::controller(categoryController::class)->group(function () {
        Route::get('/category/index', 'index')->name('category.index');
        Route::get('/category/create', 'create');
        Route::post('/category/insert', 'insert')->name('category.insert');
        Route::get('/category/{id}', 'edit')->name('category.edit');
        Route::put('/category/update/{id}','update')->name('category.update');
        Route::delete('/category/delete/{id}', 'delete')->name('category.delete');
    });
});



Route::middleware(['is_admin','add.created_by'])->group(function () {
    Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('product.index');
    Route::get('/products/create', 'create')->name('products.create');
    Route::post('/products/store', 'store')->name('products.insert');
    Route::get('/products/edit/{id}', 'edit')->name('products.edit');
    Route::post('/products/update', 'update')->name('products.update');
    Route::delete('/products/destroy/{id}', 'destroy')->name('products.destroy');
});
});
//Route::get('/user', [CartProductController::class, 'index']);
Route::get('/cartproducts/placeorder',  [CartProductController::class, 'placeorder'])->name('cartproduct.placeorder');
Route::post('/cartproducts/checkout',  [CartProductController::class, 'checkout']);

Route::get('/',  [IndexController::class, 'index'])->name('main.index');

Route::controller(CartProductController::class)->group(function () {
    Route::get('/cartproducts/{categoryId}','index')->name('cartproduct.index');
    Route::get('/cartproducts/details/{productId}','show')->name('cartproduct.show');
    //Route::get('/cartproducts/placeorder','placeorder')->name('cartproduct.placeorder');
});