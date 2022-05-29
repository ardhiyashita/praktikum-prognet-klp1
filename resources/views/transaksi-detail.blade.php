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
                                <h6 class="card-subtitle mb-2 text-muted">Total Harga</h6>
                                <h6 class="card-subtitle mb-2 text-muted">Ongkir</h6>
                            </div>
                            <div class="col-7">
                                <div class="form-inline">
                                    @foreach($transaction_detail as $transaction_details)
                                    <h6 class="card-subtitle mb-2 text-muted">{{$transaction_details->selling_price}}</h6>
                                    @endforeach
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
                        @if($transaction->status == "menunggu bukti pembayaran" or $transaction->status == "transaksi tidak terverifikasi" )
                        <div class="row">
                            <div class="progress-container mb-4">
                                <div class="white-line">
                                </div>
                            </div>
                            <div class="col">
                                <!-- <h6 class="card-subtitle mb-2 text-muted">Countdown&nbsp;:</h6> -->
                                <h6 class="card-subtitle mb-2 text-muted" id="countdown"></h6>
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

                        @elseif($transaction->status == "barang telah sampai di tujuan")
                            <div class="row">
                                <div class="progress-container mb-3">
                                    <a href="{{route('terima', $transaction_details->transaction_id)}}" class="btn btn-success mt-2" style="width: 100%;">
                                        Tandai sebagai Barang Telah Diterima
                                    </a>
                                </div>
                            </div>

                            @foreach($transaction_detail as $transaction_details)
                            <div class="white-line mb-4"></div>

                            <div class="row">
                                <div class="col-5">
                                    <h6 class="card-subtitle mb-2 text-muted">Nama Barang</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Harga Barang</h6>
                                </div>
                                <div class="col-7">
                                    <div class="form-inline">
                                        <h6 class="card-subtitle mb-2 text-muted">{{$transaction_details->product->product_name}}</h6>
                                        <h6 class="card-subtitle mb-2 text-muted">{{$transaction_details->selling_price}}</h6>
                                    </div>
                                </div>
                            </div>

                                <div class="row">
                                    <div class="progress-container mb-3">
                                        <a href="{{ route('produk-page', $transaction_details->product_id) }}" class="btn btn-info" style="width: 100%;" readonly>Berikan Ulasan</a>
                                    </div>
                                </div>
                            @endforeach
                            
                        @elseif($transaction->status == "barang dalam pengiriman")
                            <div class="row">
                                <div class="progress-container mb-3">
                                    <a href="{{route('terima', $transaction_details->transaction_id)}}" class="btn btn-success mt-2" style="width: 100%;">
                                        Tandai sebagai Barang Telah Diterima
                                    </a>
                                </div>
                            </div>

                            @foreach($transaction_detail as $transaction_details)
                            <div class="white-line mb-4"></div>

                            <div class="row">
                                <div class="col-5">
                                    <h6 class="card-subtitle mb-2 text-muted">Nama Barang</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Harga Barang</h6>
                                </div>
                                <div class="col-7">
                                    <div class="form-inline">
                                        <h6 class="card-subtitle mb-2 text-muted">{{$transaction_details->product->product_name}}</h6>
                                        <h6 class="card-subtitle mb-2 text-muted">{{$transaction_details->selling_price}}</h6>
                                    </div>
                                </div>
                            </div>

                                <div class="row">
                                    <div class="progress-container mb-3">
                                        <a href="{{ route('produk-page', $transaction_details->product_id) }}" class="btn btn-info" style="width: 100%;" readonly>Berikan Ulasan</a>
                                    </div>
                                </div>
                            @endforeach
                            
                        @endif
                        @endauth

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section: Design Block-->
</div>

<script>
    CountDownTimer('{{ $transaction->created_at }}', 'countdown');
    function CountDownTimer(dt, id)
    {
        var end = new Date('{{ $transaction->timeout }}');
        var _second = 1000;
        var _minute = _second * 60;
        var _hour = _minute * 60;
        var _day = _hour * 24;
        var timer;
        function showRemaining() {
        var now = new Date();
        var distance = end - now;
        if (distance < 0) {
        clearInterval(timer);
        return;
        }
        var days = Math.floor(distance / _day);
        var hours = Math.floor((distance % _day) / _hour);
        var minutes = Math.floor((distance % _hour) / _minute);
        var seconds = Math.floor((distance % _minute) / _second);
        document.getElementById(id).innerHTML = days + ' day ';
        document.getElementById(id).innerHTML += hours + ' hours ';
        document.getElementById(id).innerHTML += minutes + ' minutes ';
        document.getElementById(id).innerHTML += seconds + ' secs ';
    }
    timer = setInterval(showRemaining, 1000);
    }
</script>

@endsection