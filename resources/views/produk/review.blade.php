@extends('produk.mainProduk')

@section('title', 'Review Page')

@section('content')
    @auth('admin')
            <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <strong>Review</strong>
                        </div>                        
                    </div>
            <div class="card-body table-responsive">
                     <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th>No</th>
                        <th>Nama User</th>
                        <th>Review</th>
                        <th>Product</th>
                        <th>Tanggal Review</th>
                        <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($review as $item)
                        <tr>
                            <td>{{ $loop->index+1+($review->currentPage()-1)*5 }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->content }}</td>
                            <td>{{ $item->product->product_name }}</td>    
                            <td>{{ $item->created_at }}</td>
                            <td class="text-center">
                                <a href="{{ route('produk-page', $item->product_id) }}" class="btn btn-primary btn-sm">
                                    <p>Response</p>
                                </a>                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 text-center">
                        Showing 
                        {{ $review->firstItem() }}
                        To
                        {{ $review->lastItem() }}
                        Of
                        {{ $review->total() }}
                    </div>
                    <div>
                        {{ $review->links() }}
                    </div>
                </div>
        @endauth
    @endsection