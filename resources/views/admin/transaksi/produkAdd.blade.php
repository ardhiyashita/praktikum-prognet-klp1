@extends('layouts.navigation')

@section('title', 'Produk Page')

@section('content')
<!-- <div class="dark"> -->
    <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <strong>Tambah Produk</strong>
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
                                <form action="{{  url('admin/produk') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label  class="mt-2">Nama Produk</label>
                                        <input type="text" name="product_name" class="form-control mt-1 @error('product_name') is-invalid @enderror" value="{{ old('product_name') }}" autofocus>
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
                                        <input type="number" name="price" min="0" class="form-control mt-1 @error('price') is-invalid @enderror" value="{{ old('price') }}" >
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="mt-2">Stock</label>
                                        <input type="number" name="stock" min="0" class="form-control mt-1 @error('price') is-invalid @enderror" value="{{ old('stock') }}" >
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                     <div class="form-group">
                                        <label  class="mt-2">Deskripsi</label>
                                        <input type="text" name="description" class="form-control mt-1 @error('description') is-invalid @enderror" value="{{ old('description') }}" >
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label  class="mt-2">Image</label>
                                        <input type="file" name="foto" class="form-control mt-1 @error('foto') is-invalid @enderror"  >
                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label  class="mt-2">Rating</label>
                                        <input type="number" name="product_rate" min="0" max="5" class="form-control mt-1 @error('product_rate') is-invalid @enderror" value="{{ old('product_rate') }}">
                                        @error('product_rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success  mt-2 mb-2">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
