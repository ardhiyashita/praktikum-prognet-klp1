<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Login;
use App\Http\Controllers\Admin;
use App\Http\Controllers\AdmTransaksiController;
use App\Http\Controllers\Toko;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProdukController;
// use App\Http\Controllers\User;
use App\Http\Controllers\DiskonController;
use App\Models\Product;
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
Auth::routes();
Auth::routes(['verify' => true]);



Route::middleware(['guest:web'])->group(function(){
    Route::get('login',[Login::class,'login'])->name('login');
    Route::get('register',[Login::class,'register'])->name('register');
    route::post('registers_proses',[Login::class,'proses_register'])->name('register_proses');
    route::post('logins_proses',[Login::class,'proses_login'])->name('login_proses');

    //
});
Route::middleware(['auth:web'])->group(function(){
    // ROUTE YANG BISA DIAKSES SEMUA USER LOGIN - UDAH VERIFY ATAUPUN BELUM EMAILNYA
    Route::get('home',[HomeController::class, 'index'])->name('home');
    Route::get('/', [TransaksiController::class, 'landingPage'])->name('landing-page-user');
    Route::get('/{id}/produk-page', [TransaksiController::class, 'produkPage'])->name('produk-page');
    Route::middleware('email')->group(function(){
        // EMAIL YANG SUDAH TERVERIFIKASI YANG BISA MENGAKSES URL/FITUR
        Route::get('/transaksi-page', [TransaksiController::class, 'transaksiPage'])->name('transaksi-page');
        Route::get('/bukti-pembayaran-page', [TransaksiController::class, 'buktiPembayaranPage'])->name('bukti-pembayaran-page');
        Route::get('/status-transaksi-page', [TransaksiController::class, 'statusTransaksiPage'])->name('status-transaksi-page');

        // Route::get('/cart-page', [CartController::class, 'cartPage'])->name('cart-page');
        // Route::post('/cart-insert', [CartController::class, 'cartInsert'])->name('cart-insert');

        Route::post('/review/submit/{id}', [TransaksiController::class, 'review_submit'])->name('review-submit');

        Route::get('/keranjang', [TransaksiController::class, 'keranjang'])->name('keranjang');
        Route::post('/tambah/keranjang/{id}', [TransaksiController::class, 'tambah_keranjang'])->name('tambah-keranjang');
        Route::post('/keranjang/tambah/{id}', [TransaksiController::class, 'keranjang_tambah'])->name('keranjang-tambah');
        Route::get('/keranjang/hapus/{id}', [TransaksiController::class, 'keranjang_hapus'])->name('keranjang-hapus');
        Route::post('/keranjang/alamat', [TransaksiController::class, 'keranjang_alamat'])->name('keranjang-alamat');
        Route::post('/keranjang/checkout', [TransaksiController::class, 'keranjang_checkout'])->name('keranjang-checkout');
        Route::post('/keranjang/bayar', [TransaksiController::class, 'keranjang_bayar'])->name('keranjang-bayar');

        Route::post('/beli/alamat/{id}', [TransaksiController::class, 'beli_alamat'])->name('beli-alamat');
        Route::post('/beli/checkout/{id}/{jumlah}', [TransaksiController::class, 'beli_checkout'])->name('beli-checkout');
        Route::post('/beli/bayar/{id}/{jumlah}', [TransaksiController::class, 'beli_bayar'])->name('beli-bayar');

        Route::get('/transaksi', [TransaksiController::class, 'transaksi'])->name('transaksi');
        Route::get('/transaksi/detail/{id}', [TransaksiController::class, 'transaksi_detail'])->name('transaksi-detail');
        Route::post('/transaksi/bukti/{id}', [TransaksiController::class, 'transaksi_bukti'])->name('transaksi-bukti');
        Route::post('/transaksi/batal/{id}', [TransaksiController::class, 'transaksi_batal'])->name('transaksi-batal');
        Route::view('profile',[Login::class,'profile'])->name('profile');

    });
    // route::get('toko',[Toko::class,'toko'])->name('home');
    Route::post('/logout',[Login::class,'logout'])->name('logout');

});

Route::prefix('admin')->name('admin.')->group(function(){
        Route::middleware(['guest:admin'])->group(function(){
            Route::get('login',[Admin::class,'login'])->name('login');
            route::post('logins_proses',[Admin::class,'proses_login'])->name('login_proses');
        });
        Route::middleware(['auth:admin'])->group(function(){
            // Route::get('home',[Admin::class, 'index'])->name('home');
            // Route::view('home','admin.home')->name('home');
            Route::get('/home', [ProdukController::class, 'index'])->name('home');
            Route::get('/logout',[Admin::class,'logout'])->name('logout');
            // route::get('toko',[Toko::class,'toko'])->name('home');
            Route::get('/', [TransaksiController::class, 'landingPage'])->name('landing-page-user');
            Route::get('/{id}/produk-page', [AdmTransaksiController::class, 'produkPage'])->name('produk-page');
            Route::get('/transaksi-page', [TransaksiController::class, 'transaksiPage'])->name('transaksi-page');
            Route::get('/bukti-pembayaran-page', [TransaksiController::class, 'buktiPembayaranPage'])->name('bukti-pembayaran-page');
            Route::get('/status-transaksi-page', [TransaksiController::class, 'statusTransaksiPage'])->name('status-transaksi-page');

            Route::get('/cart-page', [CartController::class, 'cartPage'])->name('cart-page');
            Route::post('/cart-insert', [CartController::class, 'cartInsert'])->name('cart-insert');

            Route::get('/produk', [ProdukController::class, 'index']);
            Route::get('/produks', [ProdukController::class, 'add']);
            Route::post('/product', [ProdukController::class, 'create']);
            Route::get('/produk/edit/{id}', [ProdukController::class, 'edit']);
            Route::patch('/produk/{id}', [ProdukController::class, 'editprocess']);
            Route::delete('/produk/{id}', [ProdukController::class, 'delete']);

            Route::get('/kategori', [CategoryController::class, 'index']);
            Route::get('/kategori-add', [CategoryController::class, 'add']);
            Route::post('/kategori', [CategoryController::class, 'create']);
            Route::get('/kategori/edit/{id}', [CategoryController::class, 'edit']);
            Route::patch('/kategori/{id}', [CategoryController::class, 'editprocess']);
            Route::delete('/kategori/{id}', [CategoryController::class, 'delete']);

            Route::get('/courier', [CourierController::class, 'index']);
            Route::get('/courier-add', [CourierController::class, 'add']);
            Route::post('/courier', [CourierController::class, 'create']);
            Route::get('/courier/edit/{id}', [CourierController::class, 'edit']);
            Route::patch('/courier/{id}', [CourierController::class, 'editprocess']);
            Route::delete('/courier/{id}', [CourierController::class, 'delete']);

            Route::get('/adm/produkPage/{id}', [AdmTransaksiController::class, 'produkPage'])->name('adm-produk-page');

            Route::post('/adm/response/submit/{id}', [AdmTransaksiController::class, 'response_submit'])->name('adm-response-submit');
            Route::get('/adm/response/submit', [AdmTransaksiController::class, 'response_submit_notif'])->name('adm-response-submit-notif');
            Route::get('/adm/transaksi', [AdmTransaksiController::class, 'transaksi'])->name('adm-transaksi');
            Route::get('/transaksi/detail/{id}', [TransaksiController::class, 'transaksi_detail'])->name('transaksi-detail');
            Route::get('/adm/transaksi/detail/{id}', [AdmTransaksiController::class, 'transaksi_detail'])->name('adm-transaksi-detail');
            Route::post('/adm/transaksi/status/{id}', [AdmTransaksiController::class, 'transaksi_status'])->name('adm-transaksi-status');
            Route::get('/adm/transaksi/bukti/{id}', [AdmTransaksiController::class, 'transaksi_bukti'])->name('adm-transaksi-bukti');
            
            Route::get('/diskon', [DiskonController::class, 'index']);
            Route::get('/diskon-add', [DiskonController::class, 'add']);
            Route::post('/diskon', [DiskonController::class, 'create']);
            Route::get('/diskon/edit/{id}', [DiskonController::class, 'edit']);
            Route::patch('/diskon/{id}', [DiskonController::class, 'editprocess']);
            Route::delete('/diskon/{id}', [DiskonController::class, 'delete']);

        });

});












