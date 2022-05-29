@extends('produk.mainProduk')

@section('title', 'Diskon Page')

@section('content')
            <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <strong>Diskon</strong>
                        </div>
                        <div class="pull-right">
                            <a href="{{  url('admin/diskon-add') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add Diskon
                            </a>
                        </div>
                    </div>
            <div class="card-body table-responsive">
                     <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Presentase Diskon</th>
                        <th>Mulai</th>
                        <th>Berakhir</th>
                        <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($diskon as $item)
                        <tr>
                            <td>{{ $loop->index+1+($diskon->currentPage()-1)*5 }}</td>
                            <td>{{ $item->product->product_name }}</td>
                            <td>{{ $item->percentage }}%</td>
                            <td>{{ $item->start }}</td>
                            <td>{{ $item->end }}</td>
                            <td class="text-center">
                                <a href="{{ url('admin/diskon/edit/'.$item->id) }}" class="btn btn-primary btn-sm">
                                    <p>Edit</p>
                                </a>
                                <form action="{{ url('admin/diskon/'.$item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus Data?')">
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
                <div class="mt-4 text-center">
                        Showing 
                        {{ $diskon->firstItem() }}
                        To
                        {{ $diskon->lastItem() }}
                        Of
                        {{ $diskon->total() }}
                    </div>
                    <div>
                        {{ $diskon->links() }}
                    </div>
                </div>
    @endsection