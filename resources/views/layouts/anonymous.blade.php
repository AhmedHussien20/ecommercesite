<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 
<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <title>@yield('title')</title>
        <style>
        .navbar-nav {
            position: relative;
        }
        
        .cart-icon {
            position: absolute;
            top: 5px;
            right: 10px;
        }
        
        .cart-icon a {
            display: flex;
            align-items: center;
        }
        
        .cart-icon .cart-count {
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 5px;
            margin-left: 5px;
            font-size: 12px;
        }
        </style>
    </head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
             
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="#">Dash Board<span class="sr-only">(current)</span></a>
              </li>
            
              
              <li class="nav-item dropdown">
                
                {{-- {{ route('category.show', $category->id) }} --}}
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 Category
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  @foreach ($categories as $category)
                  <a class="dropdown-item" href="{{route('cartproduct.index',$category->id)}}"> {{ $category->name }}</a>
                  @endforeach
                </div>
               
              </li>
            </ul>
          </div>
          <div class="cart-icon">
            <a href="{{route('login')}}" id="checkout-button" class="nav-link">
                <i class="fas fa-shopping-cart"></i> Cart
                <span id="cart-count" class="badge badge-pill badge-primary"></span>
            </a>
            <script>
                // Retrieve cart data from local storage
                var cart = JSON.parse(localStorage.getItem('cart')) || [];
            
                // Count the number of items in the cart
                var count = cart.reduce(function(total, item) {
                    return total + item.quantity;
                }, 0);
            
                // Display the count in the HTML element
                document.getElementById('cart-count').textContent = count;
            </script>
        </div>
        </nav>
          <div class="container mx-auto">
            @yield('content')
          </div>
        </body>
        </html>    