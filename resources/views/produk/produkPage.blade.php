@extends('produk.mainProduk')

@section('title', 'Produk Page')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank"
                href="https://datatables.net">official DataTables documentation</a>.</p>

        
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
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Deskripsi</th>
                        <th>Rating</th>
                        <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $item)
                        <tr>
                            <td>{{ $loop->index+1+($produk->currentPage()-1)*5 }}</td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->category_name }}</td>
                            <td>Rp. {{ $item->price }}</td>
                            <td>{{ $item->stock }}</td>
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
                <div class="mt-4 text-center">
                        Showing 
                        {{ $produk->firstItem() }}
                        To
                        {{ $produk->lastItem() }}
                        Of
                        {{ $produk->total() }}
                    </div>
                    <div>
                        {{ $produk->links() }}
                    </div>
                </div>
      
        </div>
        <!-- /.container-fluid -->

@endsection