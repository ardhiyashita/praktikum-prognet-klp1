@extends('layouts.navigation')

@section('title', 'Sayur Box | Keranjang')

@section('content')

@section('css')
  <link href="{{ asset('assets/css/cart.css') }}" rel="stylesheet" />
@endsection

@if(count($keranjang) > 0)
<form method="post" action="{{route('keranjang-alamat')}}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-9">
            @php
                $harga_static = 0;
                $i = 0;
                $array_harga = array();
            @endphp

            @foreach($keranjang as $value)

            <div class="container">
                @php
                $gambar = App\Models\ProductImage::where('product_id', '=', $value->product_id)->first();
                $data = App\Models\Product::where('id', '=', $value->product_id)->first();
                @endphp
                <section id="cart">
                    <article class="product">
                        <header>
                            <a class="remove" href="{{route('keranjang-hapus', $value->id)}}">
                                <img src="../img/{{ $gambar->image_name }}" alt="" />
                                <h3>Remove product</h3>
                            </a>
                        </header>
                        <div class="content">
                            <a href="{{route('produk-page', $value->product_id)}}">
                                <h4 class="card-title">{{$data->product_name}}</h4>
                            </a>
                            @if($value->percentage == 0)
                            <h1> 
                                Rp.{{$data->price}},00
                            </h1>
                            <span>{{$data->description}}</span>
                            @else
                            <h1> 
                                <strike> {{$data->price}} </strike> 
                                <sup>{{$value->percentage}}%</sup>
                                = Rp.{{ $data->price - ($data->price * $value->percentage / 100) }},00
                            </h1>
                            <span>{{$data->description}}</span>
                            @endif
                        </div>
                        <footer class="content">
                            {{-- $totalHarga = {{$data->price}} *  --}}
                            <h2 class="full-price">Rp.{{ $data->price - ($data->price * $value->percentage / 100) }} with discount</h2>
                            {{-- <h2 class="price">Rp.{{ $data->price - ($data->price * $value->percentage / 100) }} with discount</h2> --}}
                            @php
                                $harga = $data->price - ($data->price * $value->percentage / 100);
                                array_push($array_harga, $harga);
                            @endphp


                            {{-- <span class="qt-minus">-</span>
                            <span class="qt">{{$value->qty}}</span>
                            <span class="qt-plus">+</span> --}}

                            <input class="form-control form-control-lg" style="width:70px;" type="number" name="jumlah[]" value="{{$value->qty}}" id="jumlah{{$i}}" min="1"
                            onkeyup="stock = '<?php echo $data->stock; ?>';  

                            if(this.value<0){this.value= this.value * -1}
                            
                            else if(this.value==0){this.value = 1}
                            
                            else if(this.value > stock){this.value = stock}">

                            
                        </footer>
                    </article>
                </section>
            </div>
            @endforeach
        </div>


        <div class="col-3" style="margin-top: 20px">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Total Harga</h4>
                    <div class="form-inline">
                        <h5 class="card-subtitle mb-2 mt-2 text-muted">Rp.<span class="card-subtitle mb-2 mt-2 text-muted" id="total">{{$data->price}}</span></h5>
                        
                    </div>

                    <div class="d-grid" style="align-content: center">
                        <button type="submit" class="btn-cart">Checkout</button>
                    </div>
                </div>
            </div>
        </div>



    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        
        var array_harga = <?php echo json_encode($array_harga, true); ?>;
            var total = 0;
            var indeks = 0;  
            var subtotal = 0;     
            
            $("input.form-control.form-control-lg").each(function() {
                // console.log(array_harga[indeks])
                // console.log($(this).val())
                total = total + (array_harga[indeks] * $(this).val());
                indeks++;
                // subtotal = (array_harga[indeks] * $(this).val());
                // $(".full-price").text(total);

            });
            $("#total").text(total);
        $("input.form-control.form-control-lg").click(function() {
            var array_harga = <?php echo json_encode($array_harga, true); ?>;
            var total = 0;
            var indeks = 0;            
            $("input.form-control.form-control-lg").each(function() {
                total = total + (array_harga[indeks] * $(this).val());
                indeks++;
            });
            $("#total").text(total);
        });
    });
</script>

@else
    <section id="cart">
        <div class="content">
            <img style="width: 100%;" src="{{ asset('/img/pin_7.jpg') }}" alt="">
            <h2 class="full-price pb-3" style="background-color:white; color:gray; text-align:center">! Anda belum menambahkan produk ke Cart Anda !</h2>                            
        </div>
    </section>
@endif

@endsection
