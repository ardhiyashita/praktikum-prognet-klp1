@extends('layouts.navigation')

@section('title', 'Produk Page')

@section('content')
<!-- <div class="dark"> -->
<div class="container" style="width: auto;">
    @foreach($produk as $item)
    <section class="py-5">
        <div class="container" style="display:flex; justify-content:space-between;">
            <img class="box-produk" src="/img/{{{ $item->image_name }}}" alt="">
                <div class="box-satu mb-3">
                <img src="../img/rate.png" alt="">
                    <div class="product-name">{{ $item->product_name }}</div>
                    <div class="white-line"></div>
                    <div class="price">Rp.{{ $item->price }},00</div>
                    <div class="white-line"></div>
                    <div class="box-dua">
                        <div class="detail-box">
                            <div class="roboto-hijau">Detail Produk</div>
                            <div class="roboto-abu">Kondisi</div>
                            <div class="roboto-abu">Berat</div>
                            <div class="roboto-abu">Kategori</div>
                        </div>
                        <div class="detail-data">
                            <div class="roboto-hijau">:</div>
                            <div class="roboto-hitam">Baru</div>
                            <div class="roboto-hitam">100gr</div>
                            <a href="#" class="roboto-hijau">Snack</a>
                        </div>
                    </div>
                    <div class="white-line"></div>
                    <div class="box-tiga">
                        <div class="roboto-hijau">SayurBox | Fresh Vegetables Shops in Bali</div>
                        <div class="roboto-hitam">Jln. Abiansemal XXVI No. 231, Badung, 80352</div>
                    </div>
                </div>

            <div class="box-transaction">
                <div class="box-empat mb-3 p-2">
                    <div class="product-name mb-2" style="color: #328831; font-weight: bold;">Atur Jumlah Pembelian</div>
                    <form action="">
                        <div style="justify-content: space-around;">
                            <div class="box-dua">
                                <div class="col mt-2">
                                    <input type="number" placeholder="100" value=""
                                        class="form-control ps-0 form-control-line" name="stok" 
                                        id="stok">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <button class="btn btn-outline-success tombol">Add to Cart</button>
                <a class="btn btn-outline-success tombol" href="{{ route('transaksi-page') }}">Order Now</a>
            </div>
        </div>

        <div class="container">
            <div class="box-ulasan">
                <div class="product-name">ULASAN</div>
                <div class="white-line"></div>
                <div class="box-lima">
                    <div class="profile-photo"></div>
                    <div class="roboto-hijau">Nama Pengguna
                        <div class="roboto-hitam">Lorem ipsum dolor sit amet</div>
                    </div>
                </div>
                <div class="box-lima">
                    <div class="profile-photo"></div>
                    <div class="roboto-hijau">Nama Pengguna
                        <div class="roboto-hitam">Lorem ipsum dolor sit amet</div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    @endforeach
    </div>

    <script>
        function tambah() {
            var angka = document.getElementById('jumlah-barang').value;
            document.getElementById("jumlah-barang").value = angka + document.getElementById('jumlah-barang').value;
            console.log(angka);
        }
    </script>
@endsection