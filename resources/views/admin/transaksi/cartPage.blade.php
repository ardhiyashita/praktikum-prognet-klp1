@extends('layouts.navigation')

@section('title', 'Pembayaran Page')

@section('css')
  <link href="{{ asset('assets/css/cart.css') }}" rel="stylesheet" />
@endsection

@section('content')
<header id="site-header">
  <div class="container">
    <h1>
      Shopping cart
    </h1>
  </div>
</header>

<div class="container">
  <section id="cart">
    <article class="product">
      <header>
        <a class="remove">
          <img src="https://dtq2i388ejbah.cloudfront.net/images/imagedensity/wortel_mobile_product_4x.jpg" alt="" />
          <h3>Remove product</h3>
        </a>
      </header>
      <div class="content">
        <h1></h1>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, numquam quis perspiciatis ea ad omnis
        provident laborum dolore in atque.
        <!-- <div title="You have selected this product to be shipped in the color yellow." style="top: 0"
          class="color yellow"></div>
        <div style="top: 43px" class="type small">Pcs</div> -->
      </div>
      <footer class="content">
        <span class="qt-minus">-</span>
        <span class="qt">1</span>
        <span class="qt-plus">+</span>
        <h2 class="full-price">7.999</h2>
        <h2 class="price">7.999</h2>
      </footer>
    </article>

    <article class="product">
      <header>
        <a class="remove">
          <img src="https://www.kampustani.com/wp-content/uploads/2018/01/budidaya-tomat.jpeg" alt="" />
          <h3>Remove product</h3>
        </a>
      </header>
      <div class="content">
        <h1>Lorem ipsum dolor ipsdu</h1>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, numquam quis perspiciatis ea ad omnis
        provident laborum dolore in atque.
      </div>
      <footer class="content">
        <span class="qt-minus">-</span>
        <span class="qt">1</span>
        <span class="qt-plus">+</span>
        <h2 class="full-price">1.799</h2>
        <h2 class="price">1.799</h2>
      </footer>
    </article>
  </section>
</div>

<footer id="site-footer">
  <div class="container clearfix">
    <div class="left">
      <h2 class="subtotal">Subtotal: Rp<span>163.96</span></h2>
      <h3 class="tax">Taxes (5%): Rp<span>8</span></h3>
      <h3 class="shipping">Shipping: Rp<span>5.00</span></h3>
    </div>
    <div class="right">
      <h1 class="total">Total: Rp<span>177.16</span></h1>
      <a class="btn-cart">Checkout</a>
    </div>
  </div>
</footer>
@endsection