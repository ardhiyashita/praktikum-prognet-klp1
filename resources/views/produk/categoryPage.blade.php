@extends('produk.mainProduk')

@section('title', 'Produk Page')

@section('content')
    <!-- <div class="dark"> -->
    <div class="container">
        <h1 class="h3 mb-4 text-gray-800 mb-2">Admin Kategori</h1>
    <div class="content">
        <!-- <div class="row"> -->
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
                            <td>{{ $loop->index+1+($kategori->currentPage()-1)*5  }}</td>
                            <td>{{ $item->category_name }}</td>
                            <td class="text-center">
                                <a href="{{  url('admin/kategori/edit/'.$item->id) }}" class="btn btn-primary btn-sm">
                                    <p>Edit</p>
                                </a>
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
                <div class="mt-4 text-center">
                            Showing 
                            {{ $kategori->firstItem() }}
                            To
                            {{ $kategori->lastItem() }}
                            Of
                            {{ $kategori->total() }}
                        </div>
                        <div>
                            {{ $kategori->links() }}
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
            </div>
          </div>
        <!-- </div> -->
    </div>
    </div>
@endsection