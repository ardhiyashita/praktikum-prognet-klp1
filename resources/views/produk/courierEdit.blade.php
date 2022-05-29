@extends('produk.mainProduk')

@section('title', 'Courier Page')

@section('content')
<!-- <div class="dark"> -->
    <div class="content mt-3">
            <div class="animated fadeIn">


                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <strong>Edit Kurir</strong>
                        </div>
                        <div class="pull-right">
                            <a href="{{  url('admin/courier') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-undo"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <form action="{{  url('admin/courier/'.$courier->id) }}" method="POST">
                                    @method('patch')
                                    @csrf
                                    <div class="form-group mt-2">
                                        <label>Nama Kurir</label>
                                        <input type="text" name="courier" class="form-control mt-1 @error('courier') is-invalid @enderror" value="{{ old('courier', $courier->courier) }}" autofocus>
                                        @error('courier')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success mt-2 mt-2">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
