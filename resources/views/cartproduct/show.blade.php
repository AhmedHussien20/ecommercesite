 
<style>
  /*****************globals*************/
  body {
    font-family: 'open sans';
    overflow-x: hidden; }
  
  img {
    max-width: 100%; }
  
  .preview {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
        -ms-flex-direction: column;
            flex-direction: column; }
    @media screen and (max-width: 996px) {
      .preview {
        margin-bottom: 20px; } }
  
  .preview-pic {
    -webkit-box-flex: 1;
    -webkit-flex-grow: 1;
        -ms-flex-positive: 1;
            flex-grow: 1; }
  
  .preview-thumbnail.nav-tabs {
    border: none;
    margin-top: 15px; }
    .preview-thumbnail.nav-tabs li {
      width: 18%;
      margin-right: 2.5%; }
      .preview-thumbnail.nav-tabs li img {
        max-width: 100%;
        display: block; }
      .preview-thumbnail.nav-tabs li a {
        padding: 0;
        margin: 0; }
      .preview-thumbnail.nav-tabs li:last-of-type {
        margin-right: 0; }
  
  .tab-content {
    overflow: hidden; }
    .tab-content img {
      width: 100%;
      -webkit-animation-name: opacity;
              animation-name: opacity;
      -webkit-animation-duration: .3s;
              animation-duration: .3s; }
  
  .card {
    margin-top: 50px;
    background: #eee;
    padding: 3em;
    line-height: 1.5em; }
  
  @media screen and (min-width: 997px) {
    .wrapper {
      display: -webkit-box;
      display: -webkit-flex;
      display: -ms-flexbox;
      display: flex; } }
  
  .details {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
        -ms-flex-direction: column;
            flex-direction: column; }
  
  .colors {
    -webkit-box-flex: 1;
    -webkit-flex-grow: 1;
        -ms-flex-positive: 1;
            flex-grow: 1; }
  
  .product-title, .price, .sizes, .colors {
    text-transform: UPPERCASE;
    font-weight: bold; }
  
  .checked, .price span {
    color: #ff9f1a; }
  
  .product-title, .rating, .product-description, .price, .vote, .sizes {
    margin-bottom: 15px; }
  
  .product-title {
    margin-top: 0; }
  
  .size {
    margin-right: 10px; }
    .size:first-of-type {
      margin-left: 40px; }
  
  .color {
    display: inline-block;
    vertical-align: middle;
    margin-right: 10px;
    height: 2em;
    width: 2em;
    border-radius: 2px; }
    .color:first-of-type {
      margin-left: 20px; }
  
  .add-to-cart, .like {
    background: #ff9f1a;
    padding: 1.2em 1.5em;
    border: none;
    text-transform: UPPERCASE;
    font-weight: bold;
    color: #fff;
    -webkit-transition: background .3s ease;
            transition: background .3s ease; }
    .add-to-cart:hover, .like:hover {
      background: #b36800;
      color: #fff; }
  
  .not-available {
    text-align: center;
    line-height: 2em; }
    .not-available:before {
      font-family: fontawesome;
      content: "\f00d";
      color: #fff; }
  
  .orange {
    background: #ff9f1a; }
  
  .green {
    background: #85ad00; }
  
  .blue {
    background: #0076ad; }
  
  .tooltip-inner {
    padding: 1.3em; }
  
  
    @-webkit-keyframes opacity {
    0% {
      opacity: 0;
      -webkit-transform: scale(3);
              transform: scale(3); }
    100% {
      opacity: 1;
      -webkit-transform: scale(1);
              transform: scale(1); } }
  
  @keyframes opacity {
    0% {
      opacity: 0;
      -webkit-transform: scale(3);
              transform: scale(3); }
    100% {
      opacity: 1;
      -webkit-transform: scale(1);
              transform: scale(1); } }
  
  /*# sourceMappingURL=style.css.map */

</style>
 
@if (auth()->check())
<x-app-layout>
  <x-slot name="header">
    
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Product Details') }}
    </h2>
</x-slot>
@if(isset($product))
<div class="container">
  <div class="card">
      <div class="container-fliud">
          <div class="wrapper row">
              <div class="preview col-md-6">
                  <div class="preview-pic tab-content">
                    <div class="tab-pane active" id="pic-1"><img src="{{ asset('storage/images/' . $product->image) }}" class="card-img" alt="{{ $product->name }}"></div>
                  </div>
              </div>
              <div class="details col-md-6">
                  <h3 class="product-title">{{ $product->name }}</h3>
                  <div class="rating">
                      <div class="stars">
                          <span class="fa fa-star checked"></span>
                          <span class="fa fa-star checked"></span>
                          <span class="fa fa-star checked"></span>
                          <span class="fa fa-star"></span>
                          <span class="fa fa-star"></span>
                      </div>
                      <span class="review-no">41 reviews</span>
                  </div>
                  <p class="product-description">{{ $product->description }}</p>
                  <h4 class="price">current price: <span>{{ $product->price }}</span></h4>
                   
                  
                  <div class="action">
                      <button class="add-to-cart btn btn-default"
                      data-product-id="{{ $product->id }}"
                      data-name="{{ $product->name }}"
                      data-price="{{ $product->price }}"
                      type="button">add to cart</button>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endif
</x-app-layout>
@else
@extends('layouts.anonymous')
@section('title')
  Products des
@endsection
@section('content')
@if(isset($product))
<div class="container">
    <div class="card">
        <div class="container-fliud">
            <div class="wrapper row">
                <div class="preview col-md-6">
                    <div class="preview-pic tab-content">
                      @if(isset($product->image))
                      <div class="tab-pane active" id="pic-1"><img src="{{ asset('storage/images/' . $product->image) }}" class="card-img" alt="{{ $product->name }}"></div>
                   @else
                      <p>No image available.</p>
                   @endif
                    </div>
                </div>
                <div class="details col-md-6">
                    <h3 class="product-title">{{ $product->name }}</h3>
                    <div class="rating">
                        <div class="stars">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                        </div>
                        <span class="review-no">41 reviews</span>
                    </div>
                    <p class="product-description">{{ $product->description }}</p>
                    <h4 class="price">current price: <span>{{ $product->price }}</span></h4>
                     
                    <div class="action">
                        <button class="add-to-cart btn btn-default"
                        data-product-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-price="{{ $product->price }}"
                        type="button">add to cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
@endif
<script>
  const checkoutButton = document.getElementById('checkout-button');
  const cartCountElement = checkoutButton.querySelector('.badge');
  // Add event listener to "Add to Cart" buttons
  const addToCartButtons = document.querySelectorAll('.add-to-cart');
  addToCartButtons.forEach(button => {
    button.addEventListener('click', event => {
      const productId = event.target.dataset.productId;
      const productName = event.target.dataset.name;
      const price = event.target.dataset.price;
      addToCart(productId,productName,price);
    });
  });
  
  // Add product to local storage
  function addToCart(productId,productName,price) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const product = { id: productId, quantity: 1 ,productName:productName,price:price};
    const existingProductIndex = cart.findIndex(item => item.id === productId);
    if (existingProductIndex !== -1) {
      cart[existingProductIndex].quantity++;
    } else {
      cart.push(product);
    }
    localStorage.setItem('cart', JSON.stringify(cart));
  
    //const cartCount = Object.values(cart).reduce((acc, val) => acc + val, 0);
    cartCountElement.textContent =getCartItemCount();
  }
  function getCartItemCount() {
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  let count = 0;
  for (let i = 0; i < cart.length; i++) {
    count += cart[i].quantity;
  }
  return count;
  }
  </script>