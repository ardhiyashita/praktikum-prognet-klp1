<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Cart;
use App\Models\Courier;
use App\Models\Discount;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminNotification;
use App\Notifications\UserNotification;
use phpDocumentor\Reflection\Types\Null_;

class TransaksiController extends Controller
{
    //
    use Notifiable;
    public function landing()
    {
        $produk = DB::table('products')
            ->join('product_images', 'products.id', '=', 'product_id')
            ->join('discount', 'products.id', '=', 'product_id')
            ->select('products.*', 'product_images.image_name', 'discounts.percentage')
            ->get();

        // $diskon = Discount::where('product_id', '=', $produk->id)->latest()->get();
        // dd($diskon);

        // $star = DB::table('products')
        //     ->select('products.product_rate')
        //     ->get();
        // $rate = array($star);

        //     // dd($rate);

        return view('admin.transaksi.landingPageUser', compact('produk'));
    }

    public function landingPage()
    {
        $produk = DB::table('products')
            ->join('product_images', 'products.id', '=', 'product_id')
            ->join('discounts', 'products.id', '=', 'id_product')
            ->select('products.*', 'product_images.image_name', 'discounts.percentage')                        
            ->get();

            // $star = DB::table('products')
            //     ->select('products.product_rate')
            //     ->get();
            // $rate = array($star);
    
        // dd($diskon);
    
            return view('admin.transaksi.landingPageUser', compact('produk'));
    }

    public function produkPage($id) 
    {

        $user_id = Auth::guard('web')->user()->id;
    

        $produk = DB::table('products')
            ->join('product_images', 'products.id', '=', 'product_id')
            ->select('products.*', 'product_images.image_name')
            ->where('products.id', '=', $id)
            ->get();

            // dd($produk);

        $product = Product::find($id)->get();
        
        $product_review = ProductReview::where('product_id', '=', $id)->get();
        $data_review = DB::table('responses')
            ->join('product_reviews', 'product_reviews.id', '=', 'review_id')
            ->select('responses.*', 'product_reviews.product_id')
            ->where('product_reviews.id', '=', $id)
            ->get();

        $tanggal = Carbon::now('Asia/Makassar')->format('Y-m-d');

        $discount = Discount::where('id_product', '=', $id)->where('start', '<=', $tanggal)->where('end', '>=', $tanggal)->get();

        $harga = $produk[0]->price;
        foreach ($discount as $discounts) {
            $harga = $harga - ($harga * $discounts->percentage / 100);
        }

        $cek = DB::table('transactions')
            ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->select('transactions.*', 'transaction_details.product_id')
            ->where('transactions.user_id', '=', $user_id)
            ->get();
        
        // Transaction::where('user_id', '=', $user_id)->where('product_id', '=', $id)->get();
        // dd($cek);
        foreach ($cek as $val){
            // dd($val->product_id == $id and $val->status == 'barang telah sampai di tujuan');
            if($val->product_id == $id and $val->status == 'barang telah sampai di tujuan'){
                $rev = 1;                
                return view('admin.transaksi.produkPage', compact('produk', 'discount', 'harga', 'product_review', 'rev'));
            }
        }
        // dd($cek);
        return view('admin.transaksi.produkPage', compact('produk', 'discount', 'harga', 'product_review'));
        // return view('admin.transaksi.produkPage', compact('produk', 'produk_review'));

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

    public function terima($id)
    {
        $transaction = Transaction::where('id', '=', $id)->get();
        foreach($transaction as $trans){
            $trans->status = "barang telah sampai di tujuan";
            $trans->update();
        }
        return redirect()->back();
    }

    public function statusTransaksiPage()
    {
        // $admin_id = Auth::guard('admin')->user()->id;
        $admin = Admin::find(2);
        $admin_id = $admin->id;

        $transaction = Transaction::orderBy('id', 'DESC')->paginate(10);
        // Paginator::useBootstrap();
        $tanggal = Carbon::now();
        $interval = array();
        foreach ($transaction as $transactions) {
            if ($transactions->status == "menunggu bukti pembayaran" && $transactions->timeout < $tanggal) {
                $transactions->status = "transaksi expired";
                $transactions->save();  
            }
                        
            $date = Carbon::createFromFormat('Y-m-d H:s:i', $transactions->timeout)->toDateTimeString();
            $countdown = $tanggal->diffAsCarbonInterval($date);
            array_push($interval, $countdown);
        }

        return view('admin.transaksi.statusTransaksiPage', compact('transaction', 'interval', 'admin_id'));        
    }

    public function cartPage() 
    {
        return view('admin.transaksi.cartPage');
    }

    public function keranjang()
    {
        // $user_id = DB::table('users')            
        //     ->select('id')
        //     ->where('active', '=', '1')
        //     ->get();
        $user_id = Auth::guard('web')->user()->id;
        $keranjang = DB::table('carts')
            ->join('discounts', 'discounts.id_product', '=', 'product_id')
            ->select('carts.*', 'discounts.percentage')
            ->where('user_id', '=', $user_id)
            ->where('status', '=', 'aktif')
            ->get();
            // dd($keranjang);
        
        return view('keranjang', compact('keranjang'));
    }

    public function keranjang_tambah($id, Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        $cart = Cart::where('user_id', '=', $user_id)->where('product_id', '=', $id)->get();
        $product_stock = Product::where('id',$id)->first();
        if(count($cart) > 0) {
            foreach ($cart as $carts){
                if($product_stock->stock == $carts->qty){
                    $carts->qty = $carts->qty + 0;
                    $carts->save();
                }else if($product_stock->stock < $carts->qty + $request->jumlah_keranjang){
                    $k = $carts->qty;
                    $jumlah = $product_stock->stock - $k;
                    $carts->qty = $carts->qty + $jumlah;
                    $carts->save();
                }else{
                    $carts->qty = $carts->qty + $request->jumlah_keranjang;
                    $carts->save();
                }
            }
        }else {
            $insert_cart = array(
                'user_id' => $user_id,
                'product_id' => $id,
                'qty' => $request->jumlah_keranjang,
                'status' => 'aktif'
            );
            Cart::create($insert_cart);
        }
        return redirect()->back();
    }

    public function tambah_keranjang($id)
    {
        $user_id = Auth::guard('web')->user()->id;
        $cart = Cart::where('user_id', '=', $user_id)->get();
        $product_id = Cart::where('product_id', '=', $id)->first();


        // dd($id);
        $array = [];
        foreach ($cart as $carts){
            $value_product = array($carts->product_id);
            array_push($array, $value_product);
            // $array = array_push($carts->product_id);
        }
        $check = array($array);
        if(in_array(1, $check)){
            return redirect()->back()->with('error','Produk sudah ada pada Cart Anda!');
        }
        else{
            Cart::create([
                'user_id' => $user_id,
                'product_id' => $id,
                'qty' => '1',
                'status' => 'aktif'
            ]);
            return redirect()->back()->with('success','Produk telah ditambahkan ke Cart!');
        }
    }

    public function keranjang_hapus($id)
    {
        $keranjang = Cart::find($id);
        $keranjang->status = "hapus";
        $keranjang->save();

        return redirect()->back();
    }

    public function keranjang_alamat(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        $keranjang = Cart::where('user_id', '=', $user_id)->where('status', '=', 'aktif')->get();
        $kurir = Courier::all();
        $i = 0;
        foreach ($keranjang as $keranjangs) {
            
            $keranjangs->qty = $request->jumlah[$i];
            $keranjangs->save();
            $i++;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 400f496a78d8de8e403cb03633e42774"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $province = json_decode($response, true);
        // foreach ($province["rajaongkir"]["results"] as $provinces) {
        //     return $provinces["province_id"];
        // }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 400f496a78d8de8e403cb03633e42774"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $city = json_decode($response, true);
        return view('keranjang-alamat', compact('province', 'city', 'kurir'));
    }

    public function keranjang_checkout(Request $request)
    {
        $validatedData = $request->validate([
            'province' => 'required|min:1',
            'regency' => 'required|min:1',
            'address' => 'required|min:1',
            'courier_id' => 'required|min:1'
        ]);

        $user_id = Auth::guard('web')->user()->id;
        $keranjang = Cart::where('user_id', '=', $user_id)->get();
        $kurir = Courier::find($request->courier_id);

        list($province, $province_name) = explode('|', $request->province);
        list($regency, $regency_name) = explode('|', $request->regency);
        $address = $request->address;

        $selling_price = array();
        $discount =  array();

        $keranjang = DB::table('carts')
            ->join('products', 'products.id', '=', 'product_id')    
            ->join('discounts', 'discounts.id_product', '=', 'product_id')
            ->select('carts.*', 'products.*', 'discounts.percentage')
            ->where('user_id', '=', $user_id)
            ->where('status', '=', 'aktif')
            ->get();
            
        $harga = 0;
        $subtotal = 0;
        $weight = 0;
        $tanggal = Carbon::now('Asia/Makassar')->format('Y-m-d');

        foreach ($keranjang as $keranjangs) {    
            $weight = $weight + ($keranjangs->qty * $keranjangs->weight * 100);
            $diskon = $keranjangs->percentage * $keranjangs->price / 100;
            $harga = $keranjangs->price - $diskon;
            $subtotal = $subtotal + ($keranjangs->qty * $harga);
            array_push($selling_price, $harga);    
            // array_push($discount, $diskon);    
        }
        // dd($selling_price);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=17&destination=" . $regency . "&weight=" . $weight . "&courier=" . $kurir->courier,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 400f496a78d8de8e403cb03633e42774"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $cost = json_decode($response, true);

        // return $cost;
        // dd($cost);
        foreach ($cost["rajaongkir"]["results"] as $costs) {
            foreach ($costs["costs"] as $costss) {
                foreach ($costss["cost"] as $costsss) {
                    $shipping_cost = $costsss["value"];
                    break;
                }
                break;
            }
            break;
        }

        $total = $shipping_cost + $subtotal;
        return view('keranjang-checkout', compact('keranjang', 'kurir', 'subtotal', 'selling_price', 'province_name', 'regency_name', 'address', 'shipping_cost', 'total'));
    }

    public function keranjang_bayar(Request $request)
    {
        // $total = $request->total;
        // dd($total);
        $user_id = Auth::guard('web')->user()->id;
        $courier = Courier::where('courier', '=', $request->courier)->first();
        $timeout = Carbon::now();
        $timeout->addDays(1);
        $timeout->format('Y-m-d H:i:s');
        $transaksi = array(
            'user_id' => $user_id,
            'courier_id' => $courier->id,
            'timeout' => $timeout,
            'address' => $request->address,
            'regency' => $request->regency,
            'province' => $request->province,
            'total' => $request->total,
            'shipping_cost' => $request->shipping_cost,
            'subtotal' => $request->subtotal,
            'status' => "menunggu bukti pembayaran",
        );
 
        Transaction::create($transaksi);

        $transaction = Transaction::where('user_id', '=', $user_id)->where('total', '=', $request->total)->orderBy('id', 'DESC')->first();
      
        $i = 0;
        foreach ($request->keranjang as $keranjangs) {
            $cart = Cart::where('product_id', '=', $keranjangs)->where('user_id', '=', $user_id)->where('status', '=', 'aktif')->get();
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $cart[0]->product_id,
                'qty' => $cart[0]->qty,
                'selling_price' => $request->selling_price[$i],
            ]);
            
            // TransactionDetail::create($transaksi_detail);
            $product = Product::find($cart[0]->product_id);
            $product->stock = $product->stock - $cart[0]->qty;
            $product->save();
            $i++;
        }

        $transaction = Transaction::where('user_id', '=', $user_id)->where('total', '=', $request->total)->orderBy('id', 'DESC')->first();

        // //----------------------------------------------------------------------------
        // $user=Auth::user();
        // $data_user=User::find($user->id);
        // $admin = Admin::find(2);
        // $data = [
        //     'nama'=> $user->name,
        //     'message'=>'membeli product!',
        //     'id'=> $transaction->id,
        //     'category' => 'transaction'
        // ];
        // $data_encode = json_encode($data);
        // $admin->notify(new AdminNotification($data_encode));
        // $admin->createNotif($data_encode);
        // //Notif User-------------------------------------------------------------------
        // $data = [
        //     'nama'=> 'Admin',
        //     'message'=>'Upload Bukti Pembayaran!',
        //     'id'=> $transaction->id,
        //     'category' => 'transcation'
        // ];
        // $data_encode = json_encode($data);
        // $data_user->createNotifUser($data_encode);
        // //Notif User-------------------------------------------------------------------
        $admin_id = Admin::find(2);
        $user=Auth::guard('web')->user();
        $user_id=User::find($user->id);
        $admin_id->notify(new AdminNotification('Ada order baru'));
        $user_id->notify(new UserNotification('Order sudah masuk'));

        return redirect()->route('transaksi-detail', $transaction->id);
    }

    public function beli_alamat($id, Request $request)
    {
        $jumlah = $request->jumlah_beli;
        $user_id = Auth::guard('web')->user()->id;
        $kurir = Courier::all();
        $i = 0;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 400f496a78d8de8e403cb03633e42774"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $province = json_decode($response, true);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 400f496a78d8de8e403cb03633e42774"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $city = json_decode($response, true);
        return view('beli-alamat', compact('province', 'city', 'kurir', 'id', 'jumlah'));
    }


    public function beli_checkout($id, $jumlah, Request $request)
    {
        $validatedData = $request->validate([
            'province' => 'required|min:1',
            'regency' => 'required|min:1',
            'address' => 'required|min:1',
            'courier_id' => 'required|min:1'
        ]);

        $user_id = Auth::guard('web')->user()->id;
        
        $produk = Product::where('id', '=', $id)->first();
        $kurir = Courier::find($request->courier_id)->first();

        list($province, $province_name) = explode('|', $request->province);
        list($regency, $regency_name) = explode('|', $request->regency);
        $address = $request->address;
     
        $subtotal = 0;
        $tanggal = Carbon::now('Asia/Makassar')->format('Y-m-d');
        $discount = Discount::where('id_product', '=', $id)->where('start', '<=', $tanggal)->where('end', '>=', $tanggal)->orderBy('id', 'DESC')->get();

        foreach ($discount as $discounts) {
            $selling_price = $produk->price - ($produk->price * $discounts->percentage / 100);
        }

        $weight = $produk->weight * $jumlah;
        $subtotal = $jumlah * $selling_price;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=". 114 ."&destination=" . $request->regency . "&weight=" . $weight . "&courier=" . $kurir->courier,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 400f496a78d8de8e403cb03633e42774"
            ),
        ));

        // 114 itu dps yaa kawan-kawan
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $cost = json_decode($response, true);
        
        // return $cost;
        
        foreach ($cost["rajaongkir"]["results"] as $costs) {
            foreach ($costs["costs"] as $costss) {
                    // $shipping_cost = $costss["service"];
                foreach ($costss["cost"] as $costsss) {
                    $shipping_cost = $costsss["value"];
                    $etd = $costsss["etd"];
                    break;
                }
                break;
            }
            break;
        }
                
        $total = $shipping_cost + $subtotal;
        
        return view('beli-checkout', compact('produk', 'jumlah', 'kurir', 'subtotal', 'discount', 'selling_price', 'province_name', 'regency_name', 'address', 'shipping_cost', 'etd', 'total'));
    }

    public function beli_bayar($id, $jumlah, Request $request)
    {

        $user_id = Auth::guard('web')->user()->id;

        $courier = Courier::where('courier', '=', $request->courier)->first();
        $timeout = Carbon::now('Asia/Makassar');
        $timeout->addDays(1);
        $timeout->format('Y-m-d H:i:s');
        $transaksi = array(
            'timeout' => $timeout,
            'address' => $request->alamat,
            'regency' => $request->regency,
            'province' => $request->province,
            'total' => $request->total,
            'shipping_cost' => $request->shipping_cost,
            'subtotal' => $request->subtotal,
            'proof_of_payment' => 'NULL',
            'user_id' => $user_id,
            'courier_id' => $courier->id,
            'status' => "menunggu bukti pembayaran",
        );
        Transaction::create($transaksi);

        $transaction = Transaction::where('user_id', '=', $user_id)->latest()->first();

        $transaksi_detail = array(
            'transaction_id' => $transaction->id,
            'product_id' => $id,
            'qty' => $jumlah,
            'discount' => '0',
            'selling_price' => $request->selling_price,
        );
        TransactionDetail::create($transaksi_detail);

        $product = Product::find($id);
        $product->stock = $product->stock - $jumlah;
        $product->save();

        // $admin = admin::all();

        // foreach($admin as $a)
            

        //  //----------------------------------------------------------------------------
        //  $user = User::where('active', '=', '1')->first();
        //  $user_id = $user->id;
        //  $data_user=User::find($user_id);
        //  $admin = Admin::find(1);
        //  $data = [
        //      'nama'=> $user->name,
        //      'message'=>'membeli product!',
        //      'id'=> $transaction->id,
        //      'category' => 'transcation'
        //  ];
        //  $data_encode = json_encode($data);
         
        //  $admin->createNotif($data_encode);
        //  dd($admin);
 
        //  //Notif User-------------------------------------------------------------------
        //  $data = [
        //      'nama'=> 'Admin',
        //      'message'=>'Upload Bukti Pembayaran!',
        //      'id'=> $transaction->id,
        //      'category' => 'transcation'
        //  ];
        //  $data_encode = json_encode($data);
        //  $data_user->createNotifUser($data_encode);
        //  //Notif User-------------------------------------------------------------------
        // $user_id = Auth::guard('web')->user()->id;
        // $user_id->notify(new UserNotification('Order sudah terkirim'));
        
        //$transaction_detail = TransactionDetail::where('transaction_id', '=', $transaction->id)->latest()->first();
        $admin_id = Admin::find(2);
        $user=Auth::guard('web')->user();
        $user_id=User::find($user->id);
        $admin_id->notify(new AdminNotification('Ada order baru'));
        $user_id->notify(new UserNotification('Order sudah masuk'));

        return redirect()->route('transaksi-detail',$transaction->id);
    }

    public function transaksi(){
        $user_id = Auth::guard('web')->user()->id;

        $transaction = Transaction::where('user_id', '=', $user_id)->orderBy('id', 'DESC')->get();
        $tanggal = Carbon::now('Asia/Makassar');
        $interval = array();
        $id=  Transaction::where('user_id',$user_id)->orderBy('id', 'DESC')->first();
        foreach ($transaction as $transactions) {
            if ($transactions->status == "menunggu bukti pembayaran" && $transactions->timeout < $tanggal) {
                $transactions->status = "transaksi expired";
                $transactions->save();


                $transaction_detail = TransactionDetail::where('transaction_id', '=', $transactions->id)->get();
                foreach ($transaction_detail as $transaction_details) {
                    $product = Product::find($transaction_details->product_id);
                    $product->stock = $product->stock + $transaction_details->qty;
                    $product->save();
                }

                //notif admin--------------------------------------------
                // $user=auth::user();
                // $user_data=User::find($user->id);
                // // $admin = Admin::find(6);
                // $data = [
                //     'nama'=> 'Admin7',
                //     'message'=>'Transksi Anda expired!',
                //     'id'=> $id,
                //     'category' => 'transcation'
                // ];
                // $data_encode = json_encode($data);
                // $user_data->createNotifUser($data_encode);
                //--------------------------------------------------------
                $admin_id = Admin::find(2);
                // $user=Auth::guard('web')->user();
                // $user_id=User::find($user->id);
                $admin_id->notify(new AdminNotification('Ada order expired'));
                // $user_id->notify(new UserNotification('Order sudah masuk'));
            }
            $date = Carbon::createFromFormat('Y-m-d H:s:i', $transactions->timeout);
            $countdown = $tanggal->diffAsCarbonInterval($date);
            array_push($interval, $countdown);
        }
        return view('transaksi', compact('transaction', 'interval'));
    }


    public function transaksi_detail($id)
    {
        $user_id = Auth::guard('web')->user()->id;
       
        $transaction = Transaction::where('id',$id)->first();
        $transaction_detail = TransactionDetail::where('transaction_id', $id)->latest()->get();
        $transaction_detail_id = TransactionDetail::where('transaction_id', $id)->first();
        $keranjang = Cart::where('user_id',$user_id)->get();
        foreach($keranjang as $k){
            $keranjang = Cart::find($k->id);
            $keranjang->status="hapus";
            $keranjang->update();
        }        

        $tanggal = Carbon::now('Asia/Makassar');
        
        if ($transaction->status == "menunggu bukti pembayaran" && $transaction->timeout < $tanggal) {            
            $transaction->status = "transaksi expired";
            $transaction->save();

            $transaction_detail = TransactionDetail::where('transaction_id', '=', $id)->get();
            foreach ($transaction_detail as $transaction_details) {
                $product = Product::find($transaction_details->product_id);
                $product->stock = $product->stock + $transaction_details->qty;
                $product->save();
            }

                //notif user--------------------------------------------------------
                // $user=auth::user();
                // $user_data=User::find($user->id);
                // // $admin = Admin::find(6);
                // $data = [
                //     'nama'=> 'Admin',
                //     'message'=>'Transksi expired!',
                //     'id'=> $transaction_detail_id->id,
                //     'category' => 'experied'
                // ];
                // $data_encode = json_encode($data);
                // $user_data->createNotifUser($data_encode);
                //notif user----------------------------------------------------------
                // $admin_id = Admin::find(2);
                $user=Auth::guard('web')->user();
                $user_id=User::find($user->id);
                // $admin_id->notify(new AdminNotification('Ada order baru'));
                $user_id->notify(new UserNotification('Transaksi expired'));
       
            return view('transaksi-detail', compact('transaction', 'transaction_detail'));
        } else if ($transaction->status == "menunggu bukti pembayaran" && $transaction->timeout >= $tanggal) {            
            $date = Carbon::createFromFormat('Y-m-d H:s:i', $transaction->timeout);
            $interval = $tanggal->diffAsCarbonInterval($date);
            // dd($interval);
            // $date = Carbon::createFromFormat('Y-m-d', $transaction->timeout)->toDateTimeString();
            // dd('ts');
            // $interval = $tanggal->diffAsCarbonInterval($date);
          
            // //notif admin---------------------------------------
            //  $user=auth::user();
            //  $user_data=User::find($user->id);
            //  $admin = Admin::find(3);
            //  $data = [
            //     'nama'=> $user->name,
            //     'message'=>'new Transaction!',
            //     'id'=> $id,
            //     'category' => 'transcation'
            // ];e
            // $data_encode = json_encode($data);
            // $admin->createNotif($data_encode);
            // //notif admin---------------------------------------

            //notif user---------------------------------------
        //     $user=auth::user();
        //     $user_data=User::find($user->id);
        //     $admin = Admin::find(3);
        //     $data = [
        //        'nama'=> 'admin',
        //        'message'=>'Upload Bukti Pembayaran!',
        //        'id'=> $id,
        //        'category' => 'proof'
        //    ];
        //    $data_encode = json_encode($data);
        //    $user_data->createNotifUser($data_encode);
        //    //notif user---------------------------------------
                $admin_id = Admin::find(2);
                $user=Auth::guard('web')->user();
                $user_id=User::find($user->id);
                $admin_id->notify(new AdminNotification('New transaction!'));
                $user_id->notify(new UserNotification('Upload bukti pembayaran!'));

     
            return view('transaksi-detail', compact('transaction', 'interval', 'transaction_detail', 'user_id'));
        } else if ($transaction->status == "transaksi tidak terverifikasi" && $transaction->timeout <= $tanggal) {            
            $date = Carbon::createFromFormat('Y-m-d H:s:i', $transaction->timeout);            
            $interval = $tanggal->diffAsCarbonInterval($date);
            // $date = Carbon::createFromFormat('Y-m-d', $transaction->timeout)->toDateTimeString();
            // dd('ts');
            // $interval = $tanggal->diffAsCarbonInterval($date);
          
            // //notif admin---------------------------------------
            //  $user=auth::user();
            //  $user_data=User::find($user->id);
            //  $admin = Admin::find(3);
            //  $data = [
            //     'nama'=> $user->name,
            //     'message'=>'new Transaction!',
            //     'id'=> $id,
            //     'category' => 'transcation'
            // ];e
            // $data_encode = json_encode($data);
            // $admin->createNotif($data_encode);
            // //notif admin---------------------------------------

            //notif user---------------------------------------
        //     $user=auth::user();
        //     $user_data=User::find($user->id);
        //     $admin = Admin::find(3);
        //     $data = [
        //        'nama'=> 'admin',
        //        'message'=>'Upload Bukti Pembayaran!',
        //        'id'=> $id,
        //        'category' => 'proof'
        //    ];
        //    $data_encode = json_encode($data);
        //    $user_data->createNotifUser($data_encode);
        //    //notif user---------------------------------------

            $admin_id = Admin::find(2);
            $user=Auth::guard('web')->user();
            $user_id=User::find($user->id);
            $admin_id->notify(new AdminNotification('New transaction!'));
            $user_id->notify(new UserNotification('Upload bukti pembayaran baru!'));


            
            return view('transaksi-detail', compact('transaction', 'interval', 'transaction_detail', 'user_id'));
        }else if ($transaction->status == "barang telah sampai di tujuan") {            
            
            return view('transaksi-detail', compact('transaction', 'transaction_detail', 'user_id'));
        }else {            

            //notif user---------------------------------------
            // $user=auth::user();
        //     $user_data=User::find($user->id);
        //     //$admin = Admin::find(3);
        //     $data = [
        //        'nama'=> 'admin',
        //        'message'=>$transaction->status,
        //        'id'=> $id,
        //        'category' => 'transcation'
        //    ];
        //    $data_encode = json_encode($data);
        //    $user_data->createNotifUser($data_encode);
        //    notif user---------------------------------------
            $user=Auth::guard('web')->user();
            $user_id=User::find($user->id);
            $user_id->notify(new UserNotification('{{$transaction->status}}'));

            return view('transaksi-detail', compact('transaction', 'transaction_detail'));
        }
    }

    public function review_submit($id, Request $request)
    {
        $validatedData = $request->validate([
            'content_review' => 'required'
        ]);

        $user_id = Auth::guard('web')->user()->id;
        $review = array(
            'product_id' => $id,
            'user_id' => $user_id,
            'rate' => $request->rate,
            'content' => $request->content_review
        );

        ProductReview::create($review);

        $jumlah_rate = ProductReview::where('product_id', '=', $id)->get();
        if (count($jumlah_rate) > 0) {
            $jumlah = 0;
            $total = 0;
            foreach ($jumlah_rate as $jumlah_rates) {
                $jumlah++;
                $total = $total + $jumlah_rates->rate;
            }
            $product_rate = $total / $jumlah;

            $product = Product::find($id);
            $product->product_rate = $product_rate;
            $product->save();
        }
        $user = auth::user();
        $data_user = User::find($user->id);
        if (count($jumlah_rate) == 1) {

            //----------------------------------------------------------------------------
            $admin = Admin::find(3);
            // $data = [
            //     'nama'=> $user->name,
            //     'message'=>'seseorang mereview product!',
            //     'id'=> $id,
            //     'category' => 'review'
            // ];
            // $data_encode = json_encode($data);
            // $admin->createNotif($data_encode);
            $admin->notify(new AdminNotification("Seseorang mereview product"));
        }
        return redirect()->back();
    }

    public function transaksi_bukti($id, Request $request)
    {

        $validatedData = $request->validate([
            'proof_of_payment' => 'required|file|image|max:8192'
        ]);
        $transaction = Transaction::find($id);

        $tanggal = Carbon::now('Asia/Makassar');
        if ($transaction->status == "menunggu bukti pembayaran" && $transaction->timeout < $tanggal) {
            $transaction->status = "transaksi expired";
            $transaction->save();

            $transaction_detail = TransactionDetail::where('transaction_id', '=', $id)->get();
            foreach ($transaction_detail as $transaction_details) {
                $product = Product::find($transaction_details->product_id);
                $product->stock = $product->stock + $transaction_details->qty;
                $product->save();
            }
         

            //notif user---------------------------------------
        //     $user=auth::user();
        //     $data_user=User::find($user->id);
        //     //$admin = Admin::find(6);
        //     $data = [
        //        'nama'=> 'Admin',
        //        'message'=>'Transaksi Expired!',
        //        'id'=> $id,
        //        'category' => 'experied'
        //    ];
        //    $data_encode = json_encode($data);
        //    $data_user->createNotifUser($data_encode);
           //notif user---------------------------------------
            // $admin_id = Admin::find(2);
            $user=Auth::guard('web')->user();
            $user_id=User::find($user->id);
            // $admin_id->notify(new AdminNotification('Ada order baru'));
            $user_id->notify(new UserNotification('Transaksi expired!'));

            return redirect()->back();

        }

        $image = $request->file('proof_of_payment');
        $image_name = rand() . "." . $image->getClientOriginalExtension();

        $transaction->proof_of_payment = $image_name;
        $transaction->status = "menunggu verifikasi";
        $transaction->save();

        $user=Auth::guard('web')->user();
        $user_id = User::find($user->id);
        $user_id->notify(new UserNotification("Bukti sudah terkirim"));

        //  //notif admin---------------------------------------
        //  $user=auth::user();
        //  //$user_data=User::find($user->id);
        //  $admin = Admin::find(3);
        //  $data = [
        //     'nama'=> $user->name,
        //     'message'=>'Verifikasi Pembayaran!',
        //     'id'=> $id,
        //     'category' => 'Transcation'
        // ];
        // $data_encode = json_encode($data);
        // $admin->createNotif($data_encode);
        // //notif admin---------------------------------------
        $admin_id = Admin::find(2);
        // $user=Auth::guard('web')->user();
        // $user_id=User::find($user->id);
        $admin_id->notify(new AdminNotification('Verifikasi pembayaran baru!'));
        // $user_id->notify(new UserNotification('Order sudah masuk'));

        $image->move(public_path('proof_of_payment'), $image_name);

        return redirect()->back();
    }

    public function transaksi_batal($id)
    {
        $transaction = Transaction::find($id);
        $transaction->status = "transaksi dibatalkan";
        $transaction->save();

        $transaction_detail = TransactionDetail::where('transaction_id', '=', $id)->get();
        foreach ($transaction_detail as $transaction_details) {
            $product = Product::find($transaction_details->product_id);
            $product->stock = $product->stock + $transaction_details->qty;
            $product->save();
        }

        // $user = User::where('active', '=', '1')->first();
        // $user_id = $user->id;

    //     //notif admin---------------------------------------
    //     $user=auth::user();
    //     //$user_data=User::find($user->id);
    //     $admin = Admin::find(3);
    //     $data = [
    //        'nama'=> $user->name,
    //        'message'=>'Transaksi Dibatalkan!',
    //        'id'=> $id,
    //        'category' => 'canceled'
    //    ];
    //    $data_encode = json_encode($data);
    //    $admin->createNotif($data_encode);
    //    //notif admin---------------------------------------

    //     //notif user---------------------------------------
    //     $user=auth::user();
    //     $user_data=User::find($user->id);
    //     $admin = Admin::find(3);
    //     $data = [
    //        'nama'=> 'Admin',
    //        'message'=>'Transaksi Berhasil Dibatalkan!',
    //        'id'=> $id,
    //        'category' => 'canceled'
    //    ];
    //    $data_encode = json_encode($data);
    //    $user_data->createNotifUser($data_encode);
    //    //notif user---------------------------------------
        $admin_id = Admin::find(2);
        $user=Auth::guard('web')->user();
        $user_id=User::find($user->id);
        $admin_id->notify(new AdminNotification('Transaksi dibatalkan!'));
        $user_id->notify(new UserNotification('Order berhasil dibatalkan'));
    
        // return redirect()->route('transaksi-detail', $id)->compact('user_id');
        return redirect()->back();
    }
}
