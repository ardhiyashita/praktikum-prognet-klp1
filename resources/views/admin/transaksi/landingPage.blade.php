@extends('layouts.navigation')

@section('title', 'Landing Page')

@section('content')
<form action="{{ route('cart-insert') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Let's Eat Vegetables</h1>
                    <a href="{{ url('admin/produk') }}">
                    <p>Produk</p>
                    </a>
                    <a href="{{ url('admin/kategori') }}">
                    <p>Kategori</p>
                    </a>
                    <a href="{{ url('admin/courier') }}">
                    <p>Kurir</p>
                    </a>
                    <a href="{{ url('admin/diskon') }}">
                    <p>Diskon</p>
                    </a>
                    <p class="lead fw-normal text-white-50 mb-0">get healthy life with us</p>
                </div>
            </div>
        </header>

        <!-- Alert-->
        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Section-->
        <section class="py-5">
            <div class="container mt-5" style="width: auto;">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach($produk as $item)
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <!-- Product image-->
                            <img class="card-img-top" src="../img/{{ $item->image_name }}" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ $item->product_name }}</h5>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        @for ($i = 1; $i <= $item->product_rate ; $i++)
                                            <div class="bi-star-fill"></div>
                                        @endfor
                                    </div>
                                    <!-- Product price-->
                                    <div class="roboto-hijau">
                                        <!-- <span>Rp.</span> -->
                                        Rp.{{ $item->price }},00
                                        <!-- <span>,00</span> -->
                                    </div>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center" style="display:flex; justify-content:space-around ">
                                    <a class="btn btn-outline-dark mt-auto" href="{{ route('produk-page', $item->id) }}">View</a>
                                    <button class="btn btn-outline-dark mt-auto" type="submit">Add to Cart</a>
                                    <input type="hidden" value="{{ $item->id }}" name='id'>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
@endsection
