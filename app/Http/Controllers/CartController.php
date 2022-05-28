<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\ViewServiceProvider;

use function PHPUnit\Framework\returnSelf;

class CartController extends Controller
{
    //
    public function cartPage(Type $var = null)
    {
        // $produk = Cart::all();

        return view('admin.transaksi.cartPage');
    }

    public function cartInsert(Request $request)
    {       

        $cart = Cart::create([
            'product_id' => $request->id,
            'user_id' => 1,
        ]);

        $produk = DB::table('products')
            ->join('product_images', 'products.id', '=', 'product_id')
            ->select('products.*', 'product_images.image_name')
            ->get();

        // $request->session()->flash('success', 'Produk ditambahkan ke Cart');

        return view('admin.transaksi.landingPageUser', compact('produk'))->with('success', 'Task Created Successfully!');
    }
}
