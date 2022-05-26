@extends('layouts.navigation')

@auth('admin')
@section('title', 'Sayur Box | Transaksi')
@endauth

@auth('admin')
@section('content')
<div class="card mb-3">
    <img class="card-img-top" src="{{url('proof_of_payment/'. $transaction->proof_of_payment)}}">
    <br><br>
    <div class="d-grid mx-3">
        <a type="button" class="btn btn-primary text-white" href="{{route('admin.adm-transaksi-detail', $transaction->id)}}">Kembali</a>
    </div>
</div>
@endsection
@endauth