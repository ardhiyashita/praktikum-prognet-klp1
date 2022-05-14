@extends('layouts.navigation')

@section('title', 'Produk Page')

@section('content')
<!-- <div class="dark"> -->
    <div class="content mt-3">
            <div class="animated fadeIn">


                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <strong>Tambah Kurir</strong>
                        </div>
                        <div class="pull-right">
                            <a href="{{  url('admin/courier') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-undo"></i> back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <form action="{{  url('admin/courier') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nama Kurir</label>
                                        <input type="text" name="courier" class="form-control @error('courier') is-invalid @enderror" value="{{ old('courier') }}" autofocus>
                                        @error('courier')
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
