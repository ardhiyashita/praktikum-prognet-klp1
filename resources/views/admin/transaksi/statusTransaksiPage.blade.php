@extends('layouts.navigation')

@section('title', 'Status Page')

@section('content')
<!-- <div class="dark"> -->
<div class="container my-5" 
    style="background: #FFFFFF;
    box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.2);
    border-radius: 16px;">

    <section class="py-3">
            <div class="product-name mb-2" style="color: #328831; font-weight: bold;">Status Orderan</div>
                <div class="white-line mb-3"></div>
                <div class="box-lima mb-3" style="width: auto;">
                    <div class=""></div>
                    <div class="roboto-hijau">
                    @foreach($transaction as $transactions)
                        <a href="{{route('transaksi-detail', $transactions->id)}}" style="text-decoration:none; color:#328831;">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">{{$transactions->status}}</h4>
                                    <h6 class="card-subtitle mb-3 mt-2 text-muted">Tanggal&nbsp;:&nbsp;{{$transactions->created_at->format('Y-m-d')}}</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;Rp.{{$transactions->total}}</h6>
                                    @if($transactions->status == "menunggu bukti pembayaran")
                                    <div class="form-inline">
                                        <p class="card-text">Countdown&nbsp;:&nbsp;{{$interval[$loop->index]}}</p>
                                    
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                    </div>
                </div>
                <!-- <div class="box-lima mb-3" style="width: auto;">
                    <div class="profile-photo"></div>
                    <div class="roboto-hijau">Order Satu
                        <div class="box-dua" style="padding:10px 0px">
                            <div class="detail-box">
                                <div class="roboto-hijau">Detail Produk</div>
                                <div class="roboto-abu">Kondisi</div>
                                <div class="roboto-abu">Berat</div>
                                <div class="roboto-abu">Kategori</div>
                                <div class="roboto-abu">Kurir</div>
                                <div class="price">Rp.10.000,00</div>
                            </div>
                            <div class="detail-data">
                                <div class="roboto-hijau">:</div>
                                <div class="roboto-hitam">Baru</div>
                                <div class="roboto-hitam">100gr</div>
                                <a href="#" class="roboto-hijau">Snack</a>
                                <div class="roboto-hitam">JNE Express</div>
                            </div>
                        </div>
                        <div class="roboto-hijau mb-2" style="font-size:large;">Upload Bukti Pembayaran Anda di bawah</div>
                        <input id="foto" name="foto" type="file" class="form-control">
                    </div>
                </div> -->
        
    </section>
        
    </div>
@endsection