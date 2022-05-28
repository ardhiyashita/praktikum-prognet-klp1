<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
     public function index(){
        $kategori = ProductCategory::latest()->paginate(5);
        return view('produk.categoryPage', compact('kategori'));
    }

    public function add(){
        return view('produk.categoryAddPage');
    }

    public function create(Request $request){
        $request->validate([
            'category_name'=>'required|unique:product_categories,category_name'
        ]);

        DB::table('product_categories')->insert([
            'category_name' => $request->category_name,
        ]);
        return redirect('admin/kategori');
    }

    public function edit($id)
    {
        $kategori = DB::table('product_categories')->where('id', $id)->first();
        return view('produk.categoryEditPage', compact('kategori'));
    }

    public function editprocess(Request $request, $id){
        $request->validate([

        ]);

        DB::table('product_categories')->where('id', $id)
            ->update([
            'category_name' => $request->category_name,
        ]);
        return redirect('admin/kategori');
    }

    public function delete($id)
    {
        DB::table('product_categories')->where('id', $id)->delete();
        return redirect('admin/kategori');
    }
}
