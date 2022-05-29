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

        <div class="content mt-3">
            <div class="animated fadeIn">

                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <strong>Edit Produk</strong>
                        </div>
                        <div class="pull-right">
                            <a href="{{  url('admin/produk') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-undo"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <form action="{{  url('admin/produk/'.$produk->id) }}" method="POST">
                                    @method('patch')
                                    @csrf
                                    <div class="form-group ">
                                        <label class="mt-2">Nama Produk</label>
                                        <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror mt-1" value="{{ old('product_name', $produk->product_name) }}" autofocus>
                                        @error('product_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="mt-2">Nama kategori</label>
                                        <select type="select"  id="category" name="category" class="form-control mt-1 @error('product_name') is-invalid @enderror" value="{{ old('product_name') }}" id="category" name="category" autofocus>
                                        @foreach ($category as $c)
                                            <option value="{{$c->id}}" >{{$c->category_name}}</option>
                                        @endforeach
                                        </select>
                                        @error('product_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="mt-2">Price</label>
                                        <input type="number" name="price" min="0" class="form-control @error('price') is-invalid @enderror mt-1"  value="{{ old('price', $produk->price) }}" >
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="mt-2">Stock</label>
                                        <input type="number" name="stock" min="0" class="form-control @error('price') is-invalid @enderror mt-1"  value="{{ old('stock', $produk->stock) }}" >
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                   
                                    <div class="form-group">
                                        <label  class="mt-2">Image</label>
                                        <input type="file" name="foto" class="form-control mt-1 @error('foto') is-invalid @enderror"  >
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                     <div class="form-group">
                                        <label  class="mt-2">Deskripsi</label>
                                        <input type="text" name="description" class="form-control mt-1 @error('description') is-invalid @enderror" value="{{ old('description', $produk->description) }}" >
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label  class="mt-2" >Rating</label>
                                        <input type="number" name="product_rate" min="1" max="5" class="form-control mt-1 @error('product_rate') is-invalid @enderror" value="{{ old('product_rate', $produk->product_rate) }}">
                                        @error('product_rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success mt-2 mb-2">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection