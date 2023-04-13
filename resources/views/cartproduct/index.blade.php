@if (auth()->check())
<x-app-layout>
  <x-slot name="header">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Product') }}
    </h2>
</x-slot>
<div class="container">
  
  <div class="row">
    @foreach ($products as $product)
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <img src="{{ asset('storage/images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
          <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">{{ $product->description }}</p>
            <p class="card-text">Price: ${{ $product->price }}</p>
            {{-- {{ route('products.show', $product->id) }} --}}
            <a href="{{route('cartproduct.show',$product->id)}}" class="btn btn-primary">Details</a>
            <button type="button" class="btn btn-success add-to-cart-btn" 
            data-product-id="{{ $product->id }}"
            data-name="{{ $product->name }}"
            data-price="{{ $product->price }}">Add to Cart</button>
              

          </div>
        </div>
      </div>
    @endforeach
    <script>
      const checkoutButton = document.getElementById('checkout-button');
    //if (checkoutButton) {
      const cartCountElement = checkoutButton.querySelector('.badge');
      //}
      
      // Add event listener to "Add to Cart" buttons
      const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
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
     

  </div>
  
</div>
</x-app-layout>
@else
@extends('layouts.anonymous')
@section('title')
  Products
@endsection
@section('content')
<div class="container">
  
  <div class="row">
    @foreach ($products as $product)
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <img src="{{ asset('storage/images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
          <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">{{ $product->description }}</p>
            <p class="card-text">Price: ${{ $product->price }}</p>
            {{-- {{ route('products.show', $product->id) }} --}}
            <a href="{{route('cartproduct.show',$product->id)}}" class="btn btn-primary">Details</a>
            <button type="button" class="btn btn-success add-to-cart-btn" 
            data-product-id="{{ $product->id }}"
            data-name="{{ $product->name }}"
            data-price="{{ $product->price }}">Add to Cart</button>
              
            <!-- JavaScript code -->

          </div>
        </div>
      </div>
    @endforeach
    
    <script>
      const checkoutButton = document.getElementById('checkout-button');
      const cartCountElement = checkoutButton.querySelector('.badge');
      // Add event listener to "Add to Cart" buttons
      const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
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
     
  </div>
  
</div>
@endsection
@endif




 