<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\DashboardTransactionController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardSettingController;

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

//GUEST
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{id}', [CategoryController::class, 'detail'])->name('categories-detail');

Route::get('/details/{id}', [DetailController::class, 'index'])->name('details');
Route::post('/details/{id}', [DetailController::class, 'add'])->name('details-add');

Route::get('/checkout/callback', [CheckoutController::class, 'callback'])->name('midtrans-callback');

Route::get('/success', [CartController::class, 'success'])->name('success');

Route::get('/register/success', [RegisterController::class, 'success'])->name('register-success');


//USEr/PELANGGAN
Route::middleware(['auth'])->group(
    function () {
        Route::get('/dashboard-user', [DashboardController::class, 'indexUser'])->name('dashboard-user');

        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart-delete');

        Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout');

        Route::get('/dashboard/transactions', [DashboardTransactionController::class, 'index'])->name('dashboard-transaction');
        Route::get('/dashboard/transactions/{id}', [DashboardTransactionController::class, 'details'])->name('dashboard-transaction-details');
        // Route::post('/dashboard/transactions/{id}', [DashboardTransactionController::class, 'update'])->name('dashboard-transaction-update');

        Route::get('/dashboard/account', [DashboardSettingController::class, 'account'])->name('dashboard-settings-account');
        Route::post('/dashboard/account/{redirect}', [DashboardSettingController::class, 'update'])->name('dashboard-settings-redirect');
    }
);

Route::middleware(['auth', 'admin'])->group(
    function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        //CRUD PRODUCT
        Route::get('/dashboard/products', [DashboardProductController::class, 'index'])->name('dashboard-product');
        Route::get('/dashboard/products/create', [DashboardProductController::class, 'create'])->name('dashboard-product-create');
        Route::post('/dashboard/products', [DashboardProductController::class, 'store'])->name('dashboard-product-store');
        Route::get('/dashboard/products/{id}', [DashboardProductController::class, 'details'])->name('dashboard-product-details');
        Route::post('/dashboard/products/{id}', [DashboardProductController::class, 'update'])->name('dashboard-product-update');

        //UPLOAD GALLERY
        Route::post('/dashboard/products/gallery/upload', [DashboardProductController::class, 'uploadGallery'])->name('dashboard-product-gallery-upload');
        Route::get('/dashboard/products/gallery/delete/{id}', [DashboardProductController::class, 'deleteGallery'])->name('dashboard-product-gallery-delete');

        //STORE SETTINGS
        Route::get('/dashboard/settings', [DashboardSettingController::class, 'store'])->name('dashboard-settings-store');

        //TRANSACTION
        Route::get('/dashboard/transactions-sell', [DashboardTransactionController::class, 'indexAdmin'])->name('dashboard-transaction-sell');
        Route::get('/dashboard/transactions-sell/{id}', [DashboardTransactionController::class, 'detailsAdmin'])->name('dashboard-transaction-details-admin');
        Route::post('/dashboard/transactions-sell/{id}', [DashboardTransactionController::class, 'update'])->name('dashboard-transaction-update');
    }
);

Route::prefix('admin')
    // ->namespace('Admin')
    ->middleware(['auth', 'superadmin'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin-dashboard');
        Route::resource('category', CategoryController::class);
        Route::resource('user', UserController::class);
        Route::resource('product', ProductController::class);
        Route::resource('product-gallery', ProductGalleryController::class);
        Route::resource('transaction', TransactionController::class);
    });

Auth::routes();
