<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $produk = DB::table('products')
            ->join('product_images', 'products.id', '=', 'product_id')
            ->select('products.*', 'product_images.image_name')
            ->get();
        return view('user.landingPage', compact('produk'));
    }
}
