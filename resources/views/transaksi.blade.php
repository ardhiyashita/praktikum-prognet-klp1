@extends('produk.mainProduk')

@section('title', 'Sayur Box | Transaksi')
    @section('content')
@auth('admin')

<div class="container">
    <h1 class="h3 mb-2 text-gray-800">Status Transaksi User</h1>

<table class="table table-bordered table-striped table-responsive">
    <thead>
        <tr>
            <th class="text-center" style="width: 50px;">No</th>
            <th class="text-center" style="width: 200px;">Nama User</th>
            <th class="text-center" style="width: 300px;">Status</th>
            <th class="text-center" style="width: 300px;">Tanggal</th>
            <th class="text-center" style="width: 300px;">Total</th>
            <th class="text-center" style="width: 100px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaction as $transactions)
        <tr>
            <th class="text-center"> {{$loop->index+1+($transaction->currentPage()-1)*10}}</th>
            <td class="text-center">{{$transactions->user->name}}</td>
            <td>{{$transactions->status}}</td>
            <td class="text-center">{{$transactions->created_at}}</td>
            <td class="text-center">Rp.{{$transactions->total}}</td>
            <td class="text-center">
                <a type="button" class="btn btn-primary text-white" href="{{route('admin.adm-transaksi-detail', $transactions->id)}}">Ubah Status</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
{{$transaction->links()}}

@endsection
@endauth