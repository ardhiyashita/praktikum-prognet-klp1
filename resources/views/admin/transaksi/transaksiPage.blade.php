@extends('layouts.navigation')

@section('title', 'Transaksi Page')

@section('content')
<!-- <div class="dark"> -->
<div class="container">
    <section class="py-5">
        <div class="box-transaction" style="margin: auto; padding: 10px;">
            <div class="product-name mb-2" style="color: #328831; font-weight: bold; text-align:center">Transaksi Anda</div>
                <div class="white-line mb-3"></div>
                <div class="box-empat" style="text-align: left; padding: 10px; box-shadow:none;">

                    <div class="roboto-abu" style="font-size: large;">Lokasi Anda 
                        <span style="color: red;">**</span>
                            </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1" class="roboto-hijau">Provinsi</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>NTT</option>
                                <option>Bali</option>
                                <option>Jawa</option>
                            </select>
                        <label for="exampleFormControlSelect1" class="roboto-hijau">Kota/Kabupaten</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>Denpasar</option>
                                <option>Badung</option>
                                <option>Jembrana</option>
                            </select>
                        <label for="exampleFormControlSelect1" class="roboto-hijau">Alamat</label>
                            <input type="text" class="form-control ps-0 form-control-line" placeholder="   Alamat Anda">
                    </div>
                    <div class="white-line mt-3 mb-3"></div>

                    <div class="roboto-abu" style="font-size: large;">Pilihan Kurir 
                        <span style="color: red;">**</span>
                            </div>
                    @foreach($kurir as $item)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="{{ $item->id }}">
                            <label class="form-check-label" for="exampleRadios1">
                                {{ $item->courier }}
                            </label>
                        </div>
                    @endforeach
                    <div class="roboto-abu mt-1">Estimasi Harga:
                        <i class="roboto-hijau mt-1">Rp.5.000,00</i>
                    </div>
                    
                    <div class="white-line mt-3"></div>
                        <div class="box-dua" style="padding:10px 0px">
                            <div class="detail-box">
                                <div class="roboto-hijau">Detail Order</div>
                                <div class="roboto-abu">Nama</div>
                                <div class="roboto-abu">Jumlah</div>
                                <div class="roboto-abu">Total</div>
                            </div>
                            <div class="detail-data">
                                <div class="roboto-hijau">:</div>
                                <div class="roboto-hitam">Oleh-oleh khas Bali</div>
                                <div class="roboto-hitam">10pcs</div>
                                <div class="roboto-hijau">Rp.10.000,00</div>
                            </div>
                        </div>
                    <div class="white-line mt-3"></div>
                    <div class="roboto-abu mt-3">Total Pembayaran:</div>
                    <div class="price">Rp.15.000,00</div>
                    <a class="btn btn-outline-success tombol-full" href="{{ route('bukti-pembayaran-page') }}">Bayar</a>
                    
                    
                </div>
        </div>        
    </section>
        
    </div>
@endsection