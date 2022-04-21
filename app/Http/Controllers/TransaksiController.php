<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    //
    public function landingPage()
    {
        $produk = DB::table('products')
            ->join('product_images', 'products.id', '=', 'product_id')
            ->select('products.*', 'product_images.image_name')
            ->get();

        // $star = DB::table('products')
        //     ->select('products.product_rate')
        //     ->get();
        // $rate = array($star);

        //     // dd($rate);

        return view('admin.transaksi.landingPage', compact('produk'));
    }

    public function produkPage($id) 
    {
        $produk = DB::table('products')
            ->join('product_images', 'products.id', '=', 'product_id')
            ->select('products.*', 'product_images.image_name')
            ->where('products.id', '=', $id)
            ->get();
            
        return view('admin.transaksi.produkPage', compact('produk'));

    }

    public function transaksiPage() 
    {
        $kurir = Courier::all();

        return view('admin.transaksi.transaksiPage', compact('kurir'));
    }

    public function buktiPembayaranPage() 
    {
        return view('admin.transaksi.buktiPembayaranPage');
    }

    public function statusTransaksiPage()
    {
        return view('admin.transaksi.statusTransaksiPage');
    }

    public function cartPage() 
    {
        return view('admin.transaksi.cartPage');
    }

}
