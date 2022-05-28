@extends('layouts.navigation')

@section('title', 'Sayur Box | Alamat')

@section('content')
<form method="post" action="{{route('keranjang-checkout')}}" enctype="multipart/form-data">
    @csrf
    <div class="card" style="margin-left: 390px; margin-right: 390px; margin-top: 50px; margin-bottom: 100px">
        <div class="card-header py-3"  style="text-align: center">
            <h5 class="mb-0 text-font text-uppercase">Delivery address</h5>
          </div>
        <div class="card-body">
            <div class="form-group">
                <label>Provinsi</label>
                <select class="form-control" id="provinsi" name="province">
                    @foreach($province["rajaongkir"]["results"] as $provinces)
                    <option id="{{$provinces['province_id']}}" value="{{$provinces['province_id']}}|{{$provinces['province']}}">{{$provinces["province"]}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Kota</label>
                <select class="form-control @error('regency') is-invalid @enderror" id="kota" name="regency" required>
                    <option selected value="">Pilih Kabupaten</option>
                    @foreach($city["rajaongkir"]["results"] as $citys)
                    <option id="{{$citys['province_id']}}" value="{{$citys['city_id']}}|{{$citys['city_name']}}">{{$citys["city_name"]}}</option>
                    @endforeach
                </select>
                @error('regency')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Masukkan Alamat" required spellcheck="false">
                @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Pilih Kurir</label>
                <select class="form-control @error('courier_id') is-invalid @enderror" name="courier_id" id="kurir" required>
                    <option selected value="">Pilih Kurir</option>
                    @foreach($kurir as $kurirs)
                    <option id="{{$kurirs->courier}}" value="{{$kurirs->id}}">{{$kurirs->courier}}</option>
                    @endforeach
                </select>
                @error('courier_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="d-grid mt-3 mx-3 mb-3" >
            <button type="submit" class="btn btn-primary">Selanjutnya</button>
        </div>
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

    $('#provinsi').on('click', function() {
        $("#kota option").each(function() {
            if ($(this).attr("id") == $('#provinsi').children(":selected").attr("id")) {
                $(this).show();
                $(this).prop('selected', true);
            } else {
                $(this).hide();
            }
        });
    });
</script>
@endsection