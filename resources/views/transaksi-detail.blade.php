@extends('layouts.navigation')

@section('title', 'Sayur Box | Transaksi')

@section('content')
<div class="container my-4 py-4">
    <section>
        <div class="row">
            <div class="col-6">
                <br>
                @foreach($transaction_detail as $transaction_details)
                <div class="row">
                    <div class="col-md-4">
                        @php
                        $gambar = App\Models\ProductImage::where('product_id', '=',
                        $transaction_details->product_id)->first();
                        @endphp
                        <img src="{{url('img/'. $gambar->image_name)}}" class=" rounded-3" style="width: 400px;"
                            alt="Blue Jeans Jacket" />
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4" style="text-align: center">Transaksi</h4>
                        <div class="row">

                            <div class="col-5">
                                <h6 class="card-subtitle mb-2 text-muted">Produk</h6>
                                <h6 class="card-subtitle mb-2 text-muted">Harga</h6>
                                <h6 class="card-subtitle mb-2 text-muted">Ongkir</h6>
                            </div>
                            <div class="col-7">
                                <div class="form-inline">
                                    <h6 class="card-subtitle mb-2 text-muted">{{$transaction_details->product->product_name}}</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">{{$transaction_details->selling_price}}</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">{{$transaction->shipping_cost}}</h6>
                                </div>
                            </div>
                            <div class="progress-container mb-4">
                                <div class="white-line">
                                </div>
                            </div>
                            <div class="col-5">
                                <h6 class="card-subtitle mb-2 text-muted">Total</h6>
                            </div>
                            <div class="col-7">
                                <div class="form-inline">
                                    <h6 class="card-subtitle mb-2 text-muted">Rp.{{$transaction->total}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h4 class="">{{$transaction->status}}</h4>
                        </div>

                        @auth('web')
                        @if($transaction->status == "menunggu bukti pembayaran")
                        <div class="row">
                            <div class="progress-container mb-4">
                                <div class="white-line">
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="card-subtitle mb-2 text-muted">Countdown&nbsp;:</h6>
                                <h6 class="card-subtitle mb-2 text-muted">{{$interval}}</h6>
                            </div>
                        </div>

                        <form method="post" action="{{route('transaksi-bukti', $transaction->id)}}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="d-grid">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload Bukti Pembayaran</label>
                                    <input class="form-control @error('proof_of_payment') is-invalid @enderror"
                                        type="file" name="proof_of_payment" required>
                                    @error('proof_of_payment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success" readonly>Upload</button>
                            </div>
                        </form>

                        <form method="post" action="{{route('transaksi-batal', $transaction->id)}}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger">Batal</button>
                            </div>
                        </form>
                        @endif
                        @endauth

                        @auth('admin')
                        @if($transaction->status == "menunggu bukti pembayaran")
                        <div class="row">
                            <div class="progress-container mb-4">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 100%;">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="card-subtitle mb-2 text-muted">Countdown&nbsp;:</h6>
                                <h6 class="card-subtitle mb-2 text-muted">{{$interval}}</h6>
                            </div>
                        </div>
                        @else
                        <form class="d-grid" method="post"
                            action="{{route('admin.adm-transaksi-status', $transaction->id)}}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Ubah Status</label>
                                <select class="form-control" name="status" required>
                                    <option selected value="">Pilih Status</option>
                                    <option value="menunggu verifikasi">Menunggu Verifikasi</option>
                                    <option value="sudah terverifikasi">Sudah Terverifikasi</option>
                                    <option value="transaksi dibatalkan">Transaksi Dibatalkan</option>
                                    <option value="barang dalam pengiriman">Barang Dalam Pengiriman</option>
                                    <option value="barang telah sampai di tujuan">Barang Telah Sampai Di Tujuan</option>
                                </select>
                            </div>
                            <br><br>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                        <div class="progress-container mb-4">
                        </div>
                        <div class="d-grid">
                            <a type="button" class="btn btn-info text-white"
                                href="{{route('admin.adm-transaksi-bukti', $transaction->id)}}">Lihat Bukti
                                Pembayaran</a>
                            <a href="{{url('proof_of_payment/'. $transaction->proof_of_payment)}}" type="button"
                                class="btn btn-outline-primary" download>Unduh Bukti Pembayaran</a>
                        </div>
                        @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section: Design Block-->
</div>
@endsection