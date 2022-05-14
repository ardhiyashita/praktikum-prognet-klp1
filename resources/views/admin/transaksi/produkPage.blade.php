@extends('layouts.navigation')

@section('title', 'Produk Page')

@section('content')
<!-- <div class="dark"> -->
         <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <strong>Daftar Produk</strong>
                        </div>
                        <div class="pull-right">
                            <a href="{{  url('admin/produks') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add
                            </a>
                        </div>
                    </div>
            <div class="card-body table-responsive">
                     <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Price</th>
                        <th>Deskripsi</th>
                        <th>Rating</th>
                        <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product_name }}</td>
                            <td>Rp. {{ $item->price }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->product_rate }}/5</td>
                            <td class="text-center">
                                <a href="{{ url('admin/produk/edit/'.$item->id) }}" class="btn btn-primary btn-sm">
                                    <p>Edit</p>
                                </a>
                                <form action="{{ url('admin/produk/'.$item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus Data?')">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger btn-sm">
                                        <p>Hapus</p>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
    @endsection
