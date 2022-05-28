<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use illuminate\Pagination\Paginator;
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
        //$produk = Product::latest()->paginate(5);
        $produk= DB::Table('products')->join('product_categories','products.id_category','=','product_categories.id')
        ->select('products.*','product_categories.category_name')->orderBy('products.created_at')->paginate(5);        
        return view('produk.produkPage', compact('produk'));
        // return view('admin.transaksi.produkPage', compact('produk'));
    }

    public function add(){
     
        $category= DB::Table('product_categories')->get();
        return view('produk.produkAddPage',compact('category'));
    }

    public function create(Request $request){
      
    
        $request->validate([
            'product_name' =>'required',
            'category'=>'required',
            'price'=>'required|min:0',
            'description'=>'required',
            'product_rate'=>'required|min:1|max:5',
            'foto'=>'required|image:jepg,png,jpg|max:4098',
        ]);
        $image= $request->file('foto');
        $image_name=rand().".".$image->getClientOriginalExtension();

        DB::table('products')->insert([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'id_category'=>$request->category,
            'description' => $request->description,
            'product_rate' => $request->product_rate,
            'weight' => '1',
            'stock'=>$request->stock
        ]);

        $product = Product::latest()->first();
        $id_product = $product->id;

        $date = Carbon::now();
        $date->toDateTimeString();
        // dd($date);

        DB::table('discounts')->insert([
            'id_product' => $id_product,
            'percentage' => 0,
            'start' => $date,
            'end' => $date,
        ]);

        $product_id= DB::Table('products')->where('product_name',$request->product_name)->where('id_category',$request->category)
        ->where('stock',$request->stock)->orderBy('id','desc')->value('id');
        //dd($product_id);
        DB::table('product_images')->insert([
            'product_id' => $product_id,
            'image_name' => $image_name,
        ]);
        $image->move(public_path('img'),$image_name);

        return redirect('admin/produk');
    }

    public function edit($id)
    {
        $category= DB::Table('product_categories')->get();
        $produk = DB::table('products')->where('id', $id)->first();
        return view('produk.produkEditPage', compact('produk','category'));
    }

    public function editprocess(Request $request, $id){
        $request->validate([

        ]);

        DB::table('products')->where('id', $id)
            ->update([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'stock'=>$request->stock,
            'id_category'=>$request->category,
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
