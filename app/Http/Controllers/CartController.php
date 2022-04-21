<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\View\ViewServiceProvider;

use function PHPUnit\Framework\returnSelf;

class CartController extends Controller
{
    //
    public function cartPage(Type $var = null)
    {
        // $produk = Cart::all();

        return view('modul3.cartPage');
    }

    public function cartInsert(Request $request)
    {       

        $cart = Cart::create([
            'product_id' => $request->id,
            'user_id' => 1,
        ]);
        // $request->session()->flash('success', 'Produk ditambahkan ke Cart');

        return view('modul3.landingPage')->with('success', 'Task Created Successfully!');
    }
}
