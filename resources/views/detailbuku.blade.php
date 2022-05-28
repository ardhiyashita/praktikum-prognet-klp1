@extends('layouts.navigation')

@auth('user')
@section('title', 'Sayur Box | Buku')
@endauth

@auth('admin')
@section('title', 'Admin | Buku')
@endauth

@section('content')

<div class="row">
    <div class="col-2">
        @foreach($ProductImage as $ProductImages)
        <img class="card-img-top mb-2" src="{{url('img/'. $ProductImages->image_name)}}" style="height:200px; width: auto; max-width:200px;">
        @endforeach
    </div>

    <div class="col-7">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{$book->product_name}}</h4>
                @if(!empty($discount))
                <h5 class="card-subtitle mb-2 mt-2 text-muted">Rp.{{$harga}} <span class="text-decoration-line-through">Rp.{{$book->price}}</span></h5>
                @else
                <h5 class="card-subtitle mb-2 mt-2 text-muted">Rp.{{$book->price}}</h5>
                @endif

                @if(!empty($discount))
                <h6 class="card-subtitle mb-2 text-muted">
                    Diskon&nbsp;&nbsp;:
                    @foreach($discount as $discounts)
                    @if($loop->index==0)
                    <span>{{$discounts->percentage}}%</span>
                    @else
                    <span> + {{$discounts->percentage}}%</span>
                    @endif
                    @endforeach
                </h6>
                @endif
                <h6 class="card-subtitle mb-2 text-muted">Stok&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$book->stock}}</h6>
                <h6 class="card-subtitle mb-2 text-muted">Berat&nbsp;&nbsp;&nbsp;&nbsp;: {{$book->weight}} Kg</h6>
                <p class="card-text">{{$book->description}}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-10">
                        <h4 class="card-title">Ulasan</h4>
                    </div>
                    <div class="col">
                        <h4 class="card-title" style="vertical-align: top;"><span class="material-icons-sharp" style="color: #FFE61B; vertical-align: top; font-size:27px;">star_purple500</span> {{round($book->book_rate, 1)}}</h4>
                    </div>

                </div>

                @auth('user')
                @php
                $transaksi_detail = App\Models\transaction_detail::where('product_id', '=', $book->id)->get();
                $user_id = Auth::guard('user')->user()->id;
                $cek = 0;
                if(count($transaksi_detail)>0){
                    foreach($transaksi_detail as $transaksi_details){
                        if($transaksi_details->transaction->user_id == $user_id && $transaksi_details->transaction->status == "barang telah sampai di tujuan"){
                            $cek = 1;
                        }
                    }
                }
                @endphp
                @if($cek == 1)
                <h6 class="card-subtitle text-muted mt-2 mb-1">{{Auth::guard('user')->user()->name}}</h6>
                
                <form class="form-inline" method="post" action="{{route('review-submit', $book->id)}}" enctype="multipart/form-data">
                    @csrf
                    <span class="material-icons-sharp" style="color: #FFE61B; vertical-align: top; font-size:27px;">star_purple500</span>
                    <input class="form-control form-control-lg ms-2" type="number" name="rate" value="5" min="0" max="5" onkeyup="if(this.value<=0){this.value= this.value * -1}else if(this.value>5){this.value = 5}">
                    <div class="form-group ms-2">
                        <input type="text" class="form-control @error('content_review') is-invalid @enderror" placeholder="Berikan Ulasan" style="width:395px;" name="content_review" spellcheck="false">
                        @error('content_review')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ms-2">Kirim</button>
                </form>
                @endif
                @endauth

                @if(!empty($book_review))
                @foreach($book_review as $book_reviews)
                <div class="progress-container mb-4">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 100%;">
                        </div>
                    </div>
                </div>

                <h6 class="card-subtitle text-muted">{{ $book_reviews->user->name }} &nbsp;&nbsp;<span class="material-icons-sharp" style="color: #FFE61B; vertical-align: top; font-size:15px;">star_purple500</span> {{$book_reviews->rate}}</h6>
                <p class="card-text">{{$book_reviews->content}}</p>

                @php
                $response = App\Models\response::where('review_id', '=', $book_reviews->id)->get();
                @endphp

                @if(count($response)>0)
                @foreach($response as $responses)
                <div style="margin-left:300px;">
                    <h6 class="card-subtitle text-muted">Admin | {{ $responses->admin->name }}</h6>
                    <p class="card-text mb-3">{{$responses->content}}</p>
                </div>
                @endforeach
                @endif

                @auth('admin')
                <h6 class="card-subtitle text-muted mt-2 mb-1">Admin | {{Auth::guard('admin')->user()->name}}</h6>
                <form class="form-inline" method="post" action="{{route('admin.adm-response-submit', $book_reviews->id)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control @error('content') is-invalid @enderror" placeholder="Berikan Balasan" style="width:500px;" name="content" spellcheck="false">
                        @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary ms-2">Kirim</button>
                </form>
                @endauth

                @endforeach
                @endif
            </div>
        </div>
    </div>

    @auth('user')
    @if($book->stock != 0)
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Atur Jumlah</h4>
                <input class="form-control form-control-lg" type="number" value="1" id="jumlah" min="1" max="{{$book->stock}}"  onkeyup="stock = '<?php echo $book->stock; ?>';   if(this.value<0){this.value= this.value * -1}else if(this.value==0){this.value = 1}else if(this.value > stock){this.value = stock}">
                <h6 class="card-subtitle mb-2 mt-2 text-muted">Subtotal : Rp. <span id="subtotal">
                    @if(!empty($discount))
                        {{$harga}}
                    @else
                        {{$book->price}}
                    @endif
                    </span></h6>

                <form class="d-grid" method="post" action="{{route('keranjang-tambah', $book->id)}}" enctype="multipart/form-data">
                    @csrf
                    <input type="number" class="form-control" value="1" id="keranjang" name="jumlah_keranjang" hidden>
                    <button type="submit" class="btn btn-primary">+ Keranjang</button>
                </form>

                <form class="d-grid" method="post" action="{{route('beli-alamat', $book->id)}}" enctype="multipart/form-data">
                    @csrf
                    <input type="number" class="form-control" value="1" id="beli" name="jumlah_beli" hidden>
                    <button type="submit" class="btn btn-outline-primary">Beli Langsung</button>
                </form>

            </div>
        </div>
    </div>
    @endif
    @if(!empty($discount))
        @php
            $harga_fix = $harga;
        @endphp
    @else
        @php
            $harga_fix = $book->price
        @endphp
    @endif
   
    @endauth
</div>

@auth('user')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var jumlah = "jumlah";
        var harga = "<?php echo $harga_fix; ?>";
        $("#" + jumlah).change(function() {
            var hasil = harga * $("#jumlah").val();
            $("#subtotal").text(hasil);
            $("#keranjang").val($("#jumlah").val());
            $("#beli").val($("#jumlah").val());
        });
    });
</script>
@endauth

@endsection