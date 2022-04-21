<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Login;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Toko;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes(['verify'=>true]);


Route::middleware(['guest:web'])->group(function(){
    Route::get('login',[Login::class,'login'])->name('login');
    Route::get('register',[Login::class,'register'])->name('register');
    route::post('registers_proses',[Login::class,'proses_register'])->name('register_proses');
    route::post('logins_proses',[Login::class,'proses_login'])->name('login_proses');

    //
    Route::get('/', [TransaksiController::class, 'landingPage'])->name('landing-page-user');
    Route::get('/{id}/produk-page', [TransaksiController::class, 'produkPage'])->name('produk-page');
    Route::get('/transaksi-page', [TransaksiController::class, 'transaksiPage'])->name('transaksi-page');
    Route::get('/bukti-pembayaran-page', [TransaksiController::class, 'buktiPembayaranPage'])->name('bukti-pembayaran-page');
    Route::get('/status-transaksi-page', [TransaksiController::class, 'statusTransaksiPage'])->name('status-transaksi-page');
    
    Route::get('/cart-page', [CartController::class, 'cartPage'])->name('cart-page');
    Route::post('/cart-insert', [CartController::class, 'cartInsert'])->name('cart-insert');
});
Route::middleware(['auth:web'])->group(function(){
    Route::get('home',[HomeController::class, 'index'])->name('home');
    Route::view('profile',[Login::class,'profile'])->name('profile');
    Route::post('/logout',[Login::class,'logout'])->name('logout');
    // route::get('toko',[Toko::class,'toko'])->name('home');
});

Route::prefix('admin')->name('admin.')->group(function(){
        Route::middleware(['guest:admin'])->group(function(){
            Route::get('login',[Admin::class,'login'])->name('login');
            route::post('logins_proses',[Admin::class,'proses_login'])->name('login_proses');
        });
        Route::middleware(['auth:admin'])->group(function(){
            // Route::view('home','admin.home')->name('home');
            Route::post('/logout',[Admin::class,'logout'])->name('logout');
            // route::get('toko',[Toko::class,'toko'])->name('home');
            Route::get('/home', [TransaksiController::class, 'landingPage'])->name('home');
            Route::get('/{id}/produk-page', [TransaksiController::class, 'produkPage'])->name('produk-page');
            Route::get('/transaksi-page', [TransaksiController::class, 'transaksiPage'])->name('transaksi-page');
            Route::get('/bukti-pembayaran-page', [TransaksiController::class, 'buktiPembayaranPage'])->name('bukti-pembayaran-page');
            Route::get('/status-transaksi-page', [TransaksiController::class, 'statusTransaksiPage'])->name('status-transaksi-page');
            
            Route::get('/cart-page', [CartController::class, 'cartPage'])->name('cart-page');
            Route::post('/cart-insert', [CartController::class, 'cartInsert'])->name('cart-insert');
        });

});











