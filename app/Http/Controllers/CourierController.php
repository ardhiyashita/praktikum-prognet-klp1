<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courier;
use Illuminate\Support\Facades\DB;

class CourierController extends Controller
{
    public function index(){
        $kurir = Courier::latest()->paginate(5);
        return view('admin.transaksi.courier', compact('kurir'));
    }

    public function add(){
        return view('admin.transaksi.courierAdd');
    }

    public function create(Request $request){
        $request->validate([

        ]);

        DB::table('couriers')->insert([
            'courier' => $request->courier,
        ]);

        return redirect('admin/courier');
    }

    public function edit($id)
    {
        $courier = DB::table('couriers')->where('id', $id)->first();
        return view('admin.transaksi.courierEdit', compact('courier'));
    }

    public function editprocess(Request $request, $id){
        $request->validate([

        ]);

        DB::table('couriers')->where('id', $id)
            ->update([
            'courier' => $request->courier,
        ]);
        return redirect('admin/courier');
    }

    public function delete($id)
    {
        DB::table('couriers')->where('id', $id)->delete();
        return redirect('admin/courier');
    }
}
