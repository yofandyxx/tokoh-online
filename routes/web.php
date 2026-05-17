<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\TransactionReportController;
use App\Http\Controllers\Admin\UserController;

/*
|-------------------------------------------------------------------------
| HALAMAN DEPAN
|-------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return app(ProductController::class)->home();
})->name('home');

/*
|-------------------------------------------------------------------------
| AUTH
|-------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|-------------------------------------------------------------------------
| PRODUK PUBLIC
|-------------------------------------------------------------------------
*/
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('product.show');

/*
|-------------------------------------------------------------------------
| CART
|-------------------------------------------------------------------------
*/
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
});

/*
|-------------------------------------------------------------------------
| CHECKOUT (HARUS LOGIN)
|-------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

/*
|-------------------------------------------------------------------------
| ADMIN AREA (auth + admin middleware)
|-------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('products', ProductController::class)->except(['show']);
        Route::resource('banks', BankController::class)->except(['show']);
        Route::get('transactions', [TransactionReportController::class, 'index'])->name('transactions.index');
        Route::get('transactions/recent', [TransactionReportController::class, 'recent'])->name('transactions.recent');
        Route::resource('users', UserController::class)->except(['show']);
    });
