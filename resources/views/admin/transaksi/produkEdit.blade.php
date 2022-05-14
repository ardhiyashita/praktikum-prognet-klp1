@extends('layouts.navigation')

@section('title', 'Produk Page')

@section('content')
<!-- <div class="dark"> -->
    <div class="content mt-3">
            <div class="animated fadeIn">


                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <strong>Edit Produk</strong>
                        </div>
                        <div class="pull-right">
                            <a href="{{  url('admin/produk') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-undo"></i> back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <form action="{{  url('admin/produk/'.$produk->id) }}" method="POST">
                                    @method('patch')
                                    @csrf
                                    <div class="form-group">
                                        <label>Nama Produk</label>
                                        <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror" value="{{ old('product_name', $produk->product_name) }}" autofocus>
                                        @error('product_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="number" name="price" min="0" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $produk->price) }}" >
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                     <div class="form-group">
                                        <label>Deskripsi</label>
                                        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description', $produk->description) }}" >
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Rating</label>
                                        <input type="number" name="product_rate" min="1" max="5" class="form-control @error('product_rate') is-invalid @enderror" value="{{ old('product_rate', $produk->product_rate) }}">
                                        @error('product_rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
