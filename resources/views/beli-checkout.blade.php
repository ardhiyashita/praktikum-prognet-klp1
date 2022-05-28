@extends('layouts.navigation')

@section('title', 'Sayur Box | Transaksi')

@section('content')
<form method="post" action="{{route('beli-bayar', ['id' => $produk->id, 'jumlah' => $jumlah])}}"
    enctype="multipart/form-data">
    @csrf
    <div class="container my-4 py-4">
        <section>
            <div class="row">
                <div class="col-md-4 mb-4 position-static">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            {{-- <h5 class="mb-0 text-font">1 item <span class="float-end mt-1"
                                    style="font-size: 13px ;">Edit</span></h5> --}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    @php
                                    $gambar = App\Models\ProductImage::where('product_id', '=', $produk->id)->first();
                                    @endphp
                                    <img src="/img/{{ $gambar->image_name }}" class=" rounded-3" style="width: 100px;"
                                        alt="Blue Jeans Jacket" />
                                </div>
                                <div class="col-md-6 ms-3">
                                    <span class="mb-0 text-price">Rp.{{$produk->price}}</span>
                                    <p class="mb-0 text-descriptions">
                                        {{$produk->product_name}}</p>
                                    {{-- <p class="text-descriptions mt-0">Subtotal<span
                                            class="text-descriptions fw-bold">:{{$subtotal}}</span>
                                    </p> --}}
                                </div>
                                <input type="number" class="form-control" value="{{$subtotal}}" name="subtotal" hidden>
                                <input type="number" class="form-control" value="{{$shipping_cost}}"
                                    name="shipping_cost" hidden>
                                <input type="number" class="form-control" value="{{$total}}" name="total" hidden>
                                <input type="number" class="form-control" value="{{$produk->id}}" name="produk" hidden>
                                <input type="number" class="form-control" value="{{$selling_price}}" name="selling_price" hidden>
                            </div>

                            <div class="card-footer mt-4">
                                <input type="number" class="form-control" value="{{$subtotal}}" name="subtotal" hidden>
                                <input type="number" class="form-control" value="{{$shipping_cost}}"
                                    name="shipping_cost" hidden>
                                <ul class="list-group list-group-flush">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0 text-muted">
                                        Subtotal
                                        <span>{{$subtotal}}</span>
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0 text-muted">
                                        Ongkir
                                        <span>{{$shipping_cost}}</span>
                                    </li>

                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0 fw-bold text-uppercase">
                                        Total
                                        <span>{{$total}}</span>
                                    </li>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Bayar</button>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-8">
                    <div class="col-md-12 mb-12">
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h5 class="mb-0 text-font text-uppercase">Delivery address</h5>
                            </div>
                            <div class="card-body">
                                <form>

                                    <div class="form-group">
                                        <label>Provinsi</label>
                                        <input type="text" class="form-control" readonly value="{{$province_name}}"
                                            name="province">
                                    </div>
                                    <div class="form-group">
                                        <label>Kota</label>
                                        <input type="text" class="form-control" readonly value="{{$regency_name}}"
                                            name="regency">
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control" readonly value="{{$address}}"
                                            name="alamat">
                                    </div>
                                    <div class="form-group">
                                        <label>Kurir</label>
                                        <input type="text" class="form-control" readonly value="{{$kurir->courier}}"
                                            name="courier">
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Section: Design Block-->
    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $('#kota').on('click', function() {
        $("#kota option").each(function() {
            if ($(this).attr("id") == $('#provinsi').children(":selected").attr("id")) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
</script>
@endsection