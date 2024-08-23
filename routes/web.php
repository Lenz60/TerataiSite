<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

Route::get('/template', function () {
    return view('template');
});



Route::post('/catalog',[CatalogController::class, 'cart'])->name('catalog.cart');

Route::controller(CatalogController::class)->group(function () {
    Route::get('/catalog',[CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/category={category}', [CatalogController::class, 'indexFiltered'])->name('catalog.filtered');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function (){
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'create'])->name('cart.create');
    Route::post('/cart/checkout',[CartController::class, 'checkout'])->name('cart.checkout');
    Route::delete('/cart',[CartController::class, 'destroy'])->name('cart.destroy');
    Route::put('/cart/change',[CartController::class, 'change'])->name('cart.change');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    Route::get('/orders',[OrderController::class, 'index'])->name('orders.index');
});

Route::middleware('auth')->group(function (){
    Route::get('/checkout', [CheckoutController::class,'getIndex'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class,'index'])->name('checkout.process');
    Route::post('/checkout/proceed', [CheckoutController::class,'create'])->name('checkout.create');
    Route::get('/checkout/pdf', [CheckoutController::class,'generateInvoice'])->name('checkout.pdf');
    Route::get('/pdf',[CheckoutController::class,  'pdf']);
});


require __DIR__.'/auth.php';
