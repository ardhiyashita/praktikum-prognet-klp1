<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

// use Illuminate\Http\Request;


class ProdukController extends Controller
{
    //
    // public function dashboard(Type $var = null)
    // {
    //     return view('layouts.master');

    // }

    // public function coba(Type $var = null)
    // {
    //     return view('masterCopy');
    // }

    public function index(){
        $produk = Product::all();
        return view('admin.transaksi.produkPage', compact('produk'));
    }

    public function add(){
     
        $category= DB::Table('product_categories')->get();
        return view('admin.transaksi.produkAdd',compact('category'));
    }

    public function create(Request $request){
      
        $request->validate([
            'product_name' =>'required',
            'category'=>'required',
            'price'=>'required|min:0',
            'description'=>'required',
            'product_rate'=>'required|min:1|max:5'
        ]);

        DB::table('products')->insert([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'id_category'=>$request->category,
            'description' => $request->description,
            'product_rate' => $request->product_rate,
            'weight' => '1'
        ]);
        return redirect('admin/produk');
    }

    public function edit($id)
    {
        $produk = DB::table('products')->where('id', $id)->first();
        return view('admin.transaksi.produkEdit', compact('produk'));
    }

    public function editprocess(Request $request, $id){
        $request->validate([

        ]);

        DB::table('products')->where('id', $id)
            ->update([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'description' => $request->description,
            'product_rate' => $request->product_rate,
            'weight' => '1'
        ]);
        return redirect('admin/produk');
    }

    public function delete($id)
    {
        DB::table('products')->where('id', $id)->delete();
        return redirect('admin/produk');
    }


}
