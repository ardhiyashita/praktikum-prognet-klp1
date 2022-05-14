@extends('layouts.navigation')

@section('title', 'Produk Page')

@section('content')
<!-- <div class="dark"> -->
    <div class="content">
        <div class="row">
            <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <strong>Daftar Kategori</strong>
                        </div>
                        <div class="pull-right">
                            <a href="{{  url('admin/kategori-add') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Add
                            </a>
                        </div>
                    </div>
              <div class="card-body">
                 <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                    <tr>
                      <th>NO</th>
                      <th>Nama Kategori</th>
                      <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategori as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->category_name }}</td>
                            <td class="text-center">
                                <a href="{{  url('admin/kategori/edit/'.$item->id) }}" class="btn btn-primary btn-sm">
                                    <p>Edit</p>
                                </a>
                            </td>
                            <td>
                                <form action="{{ url('admin/kategori/'.$item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus Data?')">
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
                </div>
              </div>
            </div>
          </div>
            </div>
          </div>
        </div>
    </div>
    @endsection
 {{-- <div class="card-body ">
                 <form action="{{ url('daerah') }}" method="POST">
                    @csrf
                    <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="category_name" class="form-control @error('category_name') is-invalid @enderror" value="{{ old('category_name') }}" autofocus>
                        @error('category_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    <button type="submit" class="btn btn-success">Simpan</button>
              </div> --}}