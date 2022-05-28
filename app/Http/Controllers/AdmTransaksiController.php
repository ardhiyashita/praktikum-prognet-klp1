<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Discount;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\Responses;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdmTransaksiController extends Controller
{
    public function landingPage()
    {
        $produk = DB::table('products')
            ->join('product_images', 'products.id', '=', 'product_id')
            ->select('products.*', 'product_images.image_name')
            ->get();

        // $star = DB::table('products')
        //     ->select('products.product_rate')
        //     ->get();
        // $rate = array($star);

        //     // dd($rate);

        return view('admin.transaksi.landingPageUser', compact('produk'));
    }

    public function produkPage($id)
    {
        $produk = DB::table('products')
            ->join('product_images', 'products.id', '=', 'product_id')
            ->select('products.*', 'product_images.image_name')
            ->where('products.id', '=', $id)
            ->get();
            
        $produk_image = ProductImage::where('product_id', '=', $id)->get();
        $produk_review = ProductReview::where('product_id', '=', $id)->get();

        $tanggal = Carbon::now()->format('Y-m-d');

        return view('admin.transaksi.produkPage', compact('produk', 'produk_image', 'produk_review'));            
    }

    public function response_submit($id, Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required'
        ]);

        $admin_id = auth('admin')->user()->id;
        $response = array(
            'review_id' => $id,
            'admin_id' => $admin_id,
            'content' => $request->content
        );
        Responses::create($response);

        $review = DB::Table('product_reviews')->where('id',$id)->value('user_id');
        $produk_id= DB::Table('product_reviews')->where('id',$id)->first();
        $user = User::find($review);
        
        //Notif User
        $data = [
            'nama'=> 'Admin',
            'message'=>'review anda direspon!',
            'id'=> $produk_id->product_id,
            'category' => 'review'
        ];
        $data_encode = json_encode($data);
        // $user->createNotifUser($data_encode);
        return redirect()->back();
    }


    public function transaksi()
    {
        // $admin_id = Auth::guard('admin')->user()->id;
        $admin = Admin::find(2);
        $admin_id = $admin->id;

        $transaction = Transaction::orderBy('id', 'DESC')->paginate(10);
        Paginator::useBootstrap();
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

        return view('transaksi', compact('transaction', 'interval', 'admin_id'));
    }

    public function transaksi_detail($id)
    {
        $transaction = Transaction::find($id);
        $transaction_detail = TransactionDetail::where('transaction_id', '=', $id)->get();
        $transaction_detail_id = TransactionDetail::where('transaction_id', '=', $id)->first();
        $user = User::find($transaction->user_id);
        $tanggal = Carbon::now();
        if ($transaction->status == "menunggu bukti pembayaran" && $transaction->timeout < $tanggal) {
            $transaction->status = "transaksi expired";
            $transaction->save();

            
            // $data = [
            //     'nama'=> 'Admin1',
            //     'message'=>'Transasksi Experied!',
            //     'id'=> $id,
            //     'category' => 'transcation'
            // ];

            // $data_encode = json_encode($data);
            // $user->createNotifUser($data_encode);

            return view('adm-transaksi-detail', compact('transaction', 'transaction_detail'));
        } else if ($transaction->status == "menunggu bukti pembayaran" && $transaction->timeout >= $tanggal) {
            $date = Carbon::createFromFormat('Y-m-d H:s:i', $transaction->timeout);
            $interval = $tanggal->diffAsCarbonInterval($date);

            // $data = [
            //     'nama'=> 'Admin',
            //     'message'=>'Upload Bukti Pembayaran!',
            //     'id'=> $id,
            //     'category' => 'transcation'
            // ];

            // $data_encode = json_encode($data);
            // $user->createNotifUser($data_encode);
            return view('adm-transaksi-detail', compact('transaction', 'interval', 'transaction_detail'));
        } else if ($transaction->status == "sudah terverifikasi") {

            $data = [
                'nama'=> 'Admin',
                'message'=>'sudah tervirifikasi',
                'id'=> $id,
                'category' => 'transaction'
            ];

            $data_encode = json_encode($data);
            // $user->createNotifUser($data_encode);

            return view('adm-transaksi-detail', compact('transaction', 'transaction_detail'));
        } else if ($transaction->status == "transaksi tidak terverifikasi" && $transaction->timeout >= $tanggal) {
            $date = Carbon::createFromFormat('Y-m-d H:s:i', $transaction->timeout);
            $interval = $tanggal->diffAsCarbonInterval($date);

            $data = [
                'nama'=> 'Admin',
                'message'=>'transaksi tidak terverifikasi',
                'id'=> $id,
                'category' => 'transaction'
            ];

            $data_encode = json_encode($data);
            // $user->createNotifUser($data_encode);

            return view('adm-transaksi-detail', compact('transaction', 'transaction_detail'));
        }else if ($transaction->status == "transaksi dibatalkan") {

            $data = [
                'nama'=> 'Admin',
                'message'=>'transaksi dibatalkan',
                'id'=> $id,
                'category' => 'transaction'
            ];

            $data_encode = json_encode($data);
            // $user->createNotifUser($data_encode);

            return view('adm-transaksi-detail', compact('transaction', 'transaction_detail'));
        }else if ($transaction->status == "barang dalam pengiriman") {

            $data = [
                'nama'=> 'Admin',
                'message'=>'barang dikirim',
                'id'=> $id,
                'category' => 'transaction'
            ];

            $data_encode = json_encode($data);
            // $user->createNotifUser($data_encode);

            return view('adm-transaksi-detail', compact('transaction', 'transaction_detail'));
        }else if($transaction->status == "barang telah sampai di tujuan"){
            $data = [
                'nama'=> 'Admin',
                'message'=>'barang telah sampai tujuan',
                'id'=> $id,
                'category' => 'transaction'
            ];

            $data_encode = json_encode($data);
            // $user->createNotifUser($data_encode);
            return view('adm-transaksi-detail', compact('transaction', 'transaction_detail'));   
        }else{
            return view('adm-transaksi-detail', compact('transaction', 'transaction_detail'));   
        }
    }

    public function transaksi_status($id, Request $request)
    {
        $transaction = Transaction::find($id);

        $tanggal = Carbon::now();
        if ($transaction->status == "menunggu bukti pembayaran" && $transaction->timeout < $tanggal) {
            $transaction->status = "transaksi expired";
            $transaction->save();

            // $user = User::find($transaction->user_id);
            // $data = [
            //     'nama'=> 'Admin',
            //     'message'=>'Transasksi Experied!',
            //     'id'=> $id,
            //     'category' => 'review'
            // ];
            // $data_encode = json_encode($data);
            // $user->createNotifUser($data_encode);

            return redirect()->back();;
        }
        $transaction->status = $request->status;
        $transaction->save();

        return redirect()->back();
    }

    public function transaksi_bukti($id)
    {
        $transaction = Transaction::find($id);

        return view('transaksi-bukti', compact('transaction'));
    }

    public function adminNotif($id) 
    {
        $notification = admin_notification::find($id);
        $notif = json_decode($notification->data);
        $date = Carbon::now('Asia/Makassar');
        $baca =admin_notification::find($id);
        $baca->read_at = $date;
        $baca->update();

        if ($notif->category == 'review' ) {
            return redirect()->route('adm-detailbuku',$notif->id);
        } else{
            return redirect()->route('adm-transaksi-detail',$notif->id);
        } 
        
    }
}
