<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
     public function index(){
        $kategori = ProductCategory::all();
        return view('admin.transaksi.category', compact('kategori'));
    }

    public function add(){
        return view('admin.transaksi.categoryAdd');
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
        return view('admin.transaksi.CategoryEdit', compact('kategori'));
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
