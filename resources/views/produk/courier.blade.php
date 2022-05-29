@extends('produk.mainProduk')

@section('title', 'Courier Page')

@section('content')
<!-- <div class="dark"> -->
    
            <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <strong>Daftar Kurir</strong>
                        </div>
                        <div class="pull-right">
                            <a href="{{  url('admin/courier-add') }}" class="btn btn-success btn-sm">
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
                      <th>Nama Kurir</th>
                      <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($kurir as $item)
                        <tr>
                            <td>{{ $loop->index+1+($kurir->currentPage()-1)*5 }}</td>
                            <td>{{ $item->courier }}</td>
                            <td class="text-center">
                                <a href="{{  url('admin/courier/edit/'.$item->id) }}" class="btn btn-primary btn-sm">
                                    <p>Edit</p>
                                </a>
                                <form action="{{ url('admin/courier/'.$item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus Data?')">
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
                            {{ $kurir->firstItem() }}
                            To
                            {{ $kurir->lastItem() }}
                            Of
                            {{ $kurir->total() }}
                        </div>
                        <div>
                            {{ $kurir->links() }}
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
            </div>
          </div>
        
    @endsection
