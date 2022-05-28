<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DiskonController extends Controller
{
    public function index(){
        $diskon = Discount::latest()->paginate(5);
        return view('produk.diskon', compact('diskon'));
    }

    public function add(){
        $product = Product::get();
        return view('produk.diskonAdd',compact('product'));
    }

    public function create(Request $request){
        $request->validate([
            'product' => 'required',
            'persen' => 'required',
            'start' => 'required',
            'end'=> 'required'
        ]);
       
            DB::table('discounts')->insert([
                'id_product' => $request->product,
                'percentage' => $request->persen,
                'start' => $request->start,
                'end' => $request->end
            ]);
        
        return redirect('admin/diskon');
    }

    public function edit($id)
    {
        $product=Product::all();
        $diskon = DB::table('discounts')->where('id', $id)->first();
        return view('produk.diskonEdit', compact('diskon','product'));
    }

    public function editprocess(Request $request, $id){
        $request->validate([
            'product' => 'required',
            'persen' => 'required',
            'start' => 'required','> end',
            'end'=> 'required'
        ]);

        DB::table('discounts')->where('id', $id)->update([
            'id_product' => $request->product,
            'percentage' => $request->persen,
            'start' => $request->start,
            'end' => $request->end
        ]);

        return redirect('admin/diskon');
    }

    public function delete($id)
    {
        DB::table('discounts')->where('id', $id)->delete();
        return redirect('admin/diskon');
    }
}
