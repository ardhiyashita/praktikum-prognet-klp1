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
                            <div class="card mb-2">
                                <div class="card-body">
                                @if($transactions->status == 'transaksi dibatalkan')
                                    <h4 class="card-title" style="color:darkred;">{{$transactions->status}}</h4>
                                @elseif($transactions->status == 'transaksi tidak terverifikasi')
                                    <h4 class="card-title" style="color:darkorange;">{{$transactions->status}}</h4>
                                @else
                                    <h4 class="card-title">{{$transactions->status}}</h4>
                                @endif
                                    <h6 class="card-subtitle mb-3 mt-2 text-muted">Tanggal&nbsp;:&nbsp;{{$transactions->created_at->format('Y-m-d')}}</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;Rp.{{$transactions->total}}</h6>
                                    @if($transactions->status == "menunggu bukti pembayaran")
                                    <div class="form-inline">                      
                                        <p class="card-text" id="countdown"></p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                                

                            <script>
                                CountDownTimer('{{ $transactions->created_at }}', 'countdown');
                                function CountDownTimer(dt, id)
                                {
                                    var end = new Date('{{ $transactions->timeout }}');
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
                            @endforeach

                        </a>
                    </div>
                </div>

    </section>
        
</div>
@endsection