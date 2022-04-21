@extends('layouts.navigation')

@section('title', 'Pembayaran Page')

@section('content')
<!-- <div class="dark"> -->
<div class="container my-5" 
    style="background: #FFFFFF;
    box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.2);
    border-radius: 16px;">

    <section class="py-3">
            <div class="product-name mb-2" style="color: #328831; font-weight: bold;">Menunggu Pembayaran</div>
                <div class="white-line mb-3"></div>
                <div class="box-lima mb-3" style="width: auto;">
                    <div class="profile-photo"></div>
                    <div class="roboto-hijau">

                        <div class="container" style="display: flex; justify-content:space-between; padding:0px;">
                            Order Satu
                            <div class="roboto-abu">25 February 2022 | 23:59:00</div>
                        </div>

                        <div class="box-dua" style="padding:10px 0px">
                            <div class="detail-box">
                                <div class="roboto-hijau">Detail Produk</div>
                                <div class="roboto-abu">Nama</div>
                                <div class="roboto-abu">Jumlah</div>
                                <div class="roboto-abu">Kurir</div>
                                <div class="price">Rp.10.000,00</div>
                            </div>
                            <div class="detail-data">
                                <div class="roboto-hijau">:</div>
                                <div class="roboto-hitam">Oleh-oleh khas Bali</div>
                                <div class="roboto-hitam">10pcs</div>
                                <div class="roboto-hitam">JNE Express</div>
                            </div>
                        </div>
                        <div class="roboto-hijau mb-2" style="font-size:large;">Upload Bukti Pembayaran Anda di bawah</div>
                        <input id="foto" name="foto" type="file" class="form-control">
                        
                        <div class="container" style="display:flex; justify-content:flex-end;">
                            <!-- Button yang cancel ni buat ngebatalin orderannya -->
                            <a class="btn btn-outline-success mx-1 mt-2" href="">Batalkan Orderan</a>
                            <!-- Ini ntar ada pop up berhasil dulu baru je menuju ke halaman berikutnya -->
                            <a class="btn btn-outline-success mx-1 mt-2" href="{{ route('status-transaksi-page') }}">Submit Bukti Pembayaran</a>
                        </div>
                    </div>
                </div>
                <div class="box-lima mb-3" style="width: auto;">
                    <div class="profile-photo"></div>
                    <div class="roboto-hijau">Order Satu
                        <div class="box-dua" style="padding:10px 0px">
                            <div class="detail-box">
                                <div class="roboto-hijau">Detail Produk</div>
                                <div class="roboto-abu">Nama</div>
                                <div class="roboto-abu">Jumlah</div>
                                <div class="roboto-abu">Kurir</div>
                                <div class="price">Rp.10.000,00</div>
                            </div>
                            <div class="detail-data">
                                <div class="roboto-hijau">:</div>
                                <div class="roboto-hitam">Oleh-oleh khas Bali</div>
                                <div class="roboto-hitam">10pcs</div>
                                <div class="roboto-hitam">JNE Express</div>
                            </div>
                        </div>
                        <div class="roboto-hijau mb-2" style="font-size:large;">Upload Bukti Pembayaran Anda di bawah</div>
                        <input id="foto" name="foto" type="file" class="form-control">
                        
                        <div class="container" style="display:flex; justify-content:flex-end;">
                            <!-- Button yang cancel ni buat ngebatalin orderannya -->
                            <a class="btn btn-outline-success mx-1 mt-2" href="">Batalkan Orderan</a>
                            <!-- Ini ntar ada pop up berhasil dulu baru je menuju ke halaman berikutnya -->
                            <a class="btn btn-outline-success mx-1 mt-2" href="{{ route('status-transaksi-page') }}">Submit Bukti Pembayaran</a>
                        </div>
                    </div>
                </div>
        
    </section>
        
    </div>
@endsection