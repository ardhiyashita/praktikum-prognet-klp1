@extends('layouts.navigation')

@section('title', 'Produk Page')

@section('content')
<!-- <div class="dark"> -->

<div class="container" style="width: auto;">

        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif


    @foreach($produk as $item)
    <form class="d-grid" method="post" action="{{ route('beli-alamat', $item->id) }}" enctype="multipart/form-data">
        @csrf
    <section class="py-5">
        <div class="container" style="display:flex; justify-content:space-between;">
            <img class="box-produk" src="/img/{{{ $item->image_name }}}" alt="">
                <div class="box-satu mb-3">
                <div class="product-name" style="font-size: 30px;">{{ $item->product_name }}</div>
                <div class="d-flex text-warning">
                    @for ($i = 1; $i <= $item->product_rate ; $i++)
                        <div class="bi-star-fill"></div>
                    @endfor
                </div>
                    <div class="white-line"></div>
                    <div class="price">Rp.{{ $harga }},00</div>
                    <div class="white-line"></div>
                    <div class="box-dua">
                        <div class="detail-box">
                            <div class="roboto-hijau">Detail Produk</div>
                            <div class="roboto-abu">Diskon</div>
                            <div class="roboto-abu">Harga Awal</div>
                            <div class="roboto-abu">Kondisi</div>
                        </div>
                        <div class="detail-data">
                            <div class="roboto-hijau">:</div>
                            <div class="roboto-hitam">
                                @foreach ($discount as $discounts)
                                    @if($discounts->percentage == 0)
                                        Tidak ada diskon
                                    @else
                                        {{ $discounts->percentage }}%
                                    @endif
                                @endforeach
                            </div>
                            <div class="roboto-hitam">Rp.{{ $item->price }},00</div>
                            <div class="roboto-hijau">Fresh</div>
                        </div>
                    </div>
                    <div class="white-line"></div>
                    <div class="box-tiga">
                        <div class="roboto-hijau">SayurBox | Fresh Vegetables Shops in Bali</div>
                        <div class="roboto-hitam">Jln. Gunung Agung XXVI No. 231, Denpasar</div>
                    </div>
                </div>

            <div class="box-transaction">
                <div class="box-empat mb-3 p-2">
                    <div class="product-name mb-2" style="color: #328831; font-weight: bold;">Atur Jumlah Pembelian</div>
                        <div style="justify-content: space-around;">
                            <div class="box-dua">
                                <div class="col mt-2">
                                    <input type="number" placeholder="1" value=""
                                        class="form-control ps-0 form-control-line" name="jumlah_beli" 
                                        id="stok">
                                </div>
                            </div>
                        </div>
                    </div>
               <!-- <a class="btn btn-outline-success tombol" href="{{ route('transaksi-page') }}">Order Now</a> -->
                
                <button class="btn btn-outline-success tombol" type="submit">Order Now</a>
                </form>

                <form class="d-grid" method="post" action="{{ route('tambah-keranjang', $item->id) }}" enctype="multipart/form-data">
                    @csrf
                    <button class="btn btn-outline-success tombol">Add to Cart</button>
                </form>
            </div>
        </div>
        




        <div class="container">
            <div class="box-ulasan">
                <div class="product-name">ULASAN</div>
                <div class="white-line"></div>
                @if(!empty($product_review))
                    @foreach($product_review as $value)
                        <div class="box-lima">
                            <div class="profile-photo"></div>
                            <div class="roboto-hijau" style="font-size:larger"> {{ $value->user->name }}
                            <div class="d-flex small text-warning">
                                @for ($i = 1; $i <= $value->rate ; $i++)
                                    <div class="bi-star-fill"></div>
                                @endfor
                            </div>
                            <div class="roboto-hitam mb-2">{{ $value->content }}</div>
                                @php
                                    $response = DB::table('responses')
                                        ->join('product_reviews', 'product_reviews.id', '=', 'review_id')
                                        ->join('admins', 'admins.id', '=', 'admin_id')
                                        ->select('responses.*', 'product_reviews.product_id', 'product_reviews.user_id', 'admins.name')
                                        ->where('review_id', '=', $value->id)
                                        ->where('product_id', '=', $item->id)
                                        ->get();                                        
                                @endphp

                                @foreach($response as $responses)
                                    <div class="white-line"></div>
                                    <div class="mt-3">
                                        <h6 class="card-subtitle text-muted">Balasan: Admin | {{$responses->name}}</h6>
                                        <p class="card-text mb-3">{{$responses->content}}</p>
                                    </div>
                                    @endforeach



                                @auth('admin')

                                    @php
                                        $response = DB::table('responses')
                                            ->join('product_reviews', 'product_reviews.id', '=', 'review_id')
                                            ->select('responses.*', 'product_reviews.product_id', 'product_reviews.user_id')
                                            ->where('review_id', '=', $value->id)
                                            ->where('product_id', '=', $item->id)
                                            ->get();  
                                            
                                            $rev = null;                                        
                                    @endphp

                                    @foreach($response as $responses)
                                    <div class="white-line"></div>
                                    <div class="mt-3">
                                        <h6 class="card-subtitle text-muted">Balasan: Admin | {{Auth::guard('admin')->user()->name}}</h6>
                                        <p class="card-text mb-3">{{$responses->content}}</p>
                                    </div>
                                    @endforeach

                                    <div class="container mt-3">
                                        <div class="white-line"></div>
                                            <h6 class="card-subtitle text-muted mt-2 mb-1">Admin | {{Auth::guard('admin')->user()->name}}</h6>
                                            @if(count($product_review)>0)
                                                @foreach($product_review as $value)
                                                    <form class="form-inline" method="post" action="{{route('admin.adm-response-submit', $value->id)}}" enctype="multipart/form-data">
                                                        @csrf
                                                        @endforeach
                                                        <div class="form-group">
                                                            <input type="text" class="form-control @error('content') is-invalid @enderror" placeholder="Berikan Balasan" name="content" spellcheck="false">
                                                            @error('content')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <button type="submit" class="btn btn-primary mt-2 ms-2">Kirim</button>
                                                    </form>                                                
                                            @else
                                                <div>Tidak ada ulasan untuk produk ini</div>
                                            @endif
                                        </div>



                                @endauth


                            </div>
                        </div>
                    @endforeach
                @else
                    <div>Tidak ada ulasan untuk produk ini</div>
                @endif




            @if(!empty($rev))          
            <div class="box-lima">
                <div class="profile-photo"></div>             
                    <form class="form-inline" method="post" action="{{route('review-submit', $item->id)}}" enctype="multipart/form-data">
                        @csrf                    
                        <div class="roboto-hijau" style="font-size:larger"> {{Auth::guard('web')->user()->name}}</div> 
                        <div class="form-group">
                            Berikan Rating <input class="form-control mb-2" type="number" name="rate" value="5" min="0" max="5">
                            Berikan Ulasan <input type="text" class="form-control mb-2 @error('content_review') is-invalid @enderror" placeholder="Berikan Ulasan" name="content_review" spellcheck="false">
                            @error('content_review')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
            </div>
            @else
            <div></div>

            @endif
        
    </section>
    </div>
    @endforeach

    <script>
        function tambah() {
            var angka = document.getElementById('jumlah-barang').value;
            document.getElementById("jumlah-barang").value = angka + document.getElementById('jumlah-barang').value;
            console.log(angka);
        }
    </script>
@endsection