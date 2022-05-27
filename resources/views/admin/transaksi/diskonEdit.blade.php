@extends('layouts.navigation')

@section('title', 'Produk Page')

@section('content')

<!-- <div class="dark"> -->
    <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <strong>Tambah Diskon</strong>
                        </div>
                        <div class="pull-right">
                            <a href="{{  url('admin/diskon') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-undo"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <form action="{{  url('admin/diskon/'.$diskon->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label  class="mt-2">Nama Produk</label>
                                        <select type="select"  id="product" name="product" class="form-control mt-1 @error('product') is-invalid @enderror" value="{{ old('product') }}" autofocus>
                                        @foreach ($product as $c)
                                            <option value="{{$c->id}}" >{{$c->product_name}}</option>
                                        @endforeach
                                        </select>
                                        @error('product_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror 
                                    </div>
                                    <div class="form-group">
                                        <label class="mt-2">Persentase Diskon</label>
                                        <input type="number" name="persen" id="persen" value="{{$diskon->percentage}}" min='0' max='100' class="form-control mt-1 @error('persen') is-invalid @enderror" value="{{ old('persen') }}" autofocus>
                                        @error('persen')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="mt-2">Start</label>
                                        <input type="date" name="start" value ="{{$diskon->start}}" class="form-control mt-1 @error('start') is-invalid @enderror" value="{{ old('start') }}" >
                                        @error('start')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="mt-2">End</label>
                                        <input type="date" name="end" value="{{$diskon->end}}" class="form-control mt-1 @error('end') is-invalid @enderror" value="{{ old('end') }}" >
                                        @error('end')
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
