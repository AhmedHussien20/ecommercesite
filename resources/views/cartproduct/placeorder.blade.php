<style>
    .row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #04AA6D;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (and change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
</style>
<x-app-layout>
    <x-slot name="header">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">

      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Place Order') }}
      </h2>
  </x-slot> 
 <div class="row">
    <div class="col-75">
      <div class="container">
        <form id="checkout-form">
        @csrf
          <div class="row">
            <div class="col-50">
              <h3>Billing Address</h3>
              <label for="fname"><i class="fa fa-user"></i> Full Name</label>
              <input type="text" id="fname" name="fname" placeholder="Full Name">
              <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
              <input type="text" id="address" name="address" placeholder="Address">
              <label for="city"><i class="fa fa-institution"></i> City</label>
              <input type="text" id="city" name="city" placeholder="city">
            </div>
  
            <div class="col-50">
              <h3>Payment</h3>
              <label for="acce">Accepted Cards</label>
              <div class="icon-container">
                <i class="fa fa-cc-visa" style="color:navy;"></i>
                <i class="fa fa-cc-amex" style="color:blue;"></i>
                <i class="fa fa-cc-mastercard" style="color:red;"></i>
                <i class="fa fa-cc-discover" style="color:orange;"></i>
              </div>
              <label for="cname">Name on Card</label>
              <input type="text" id="cardname" name="cardname" placeholder="Name on Card">
              <label for="ccnum">Credit card number</label>
              <input type="text" id="cardnumber" name="cardnumber" placeholder="Credit card number">
              <label for="expmonth">Exp Month</label>
              <input type="text" id="expmonth" name="expmonth" placeholder="Exp Month">
  
              <div class="row">
                <div class="col-50">
                  <label for="expyear">Exp Year</label>
                  <input type="text" id="expyear" name="expyear" placeholder="Exp Year">
                </div>
                <div class="col-50">
                  <label for="cvv">CVV</label>
                  <input type="text" id="cvv" name="cvv" placeholder="CVV">
                </div>
              </div>
            </div>
  
          </div>
          <label>
            <input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
          </label>
          <input type="submit" value="Continue to checkout" class="btn">
        </form>
      </div>
    </div>
    <div class="col-25">
        <div class="container">
            <h4>Cart
              <span class="price" style="color:black">
                <i class="fa fa-shopping-cart"></i>
                <b id="cart-count"></b>
              </span>
            </h4>
            <div id="cart-items">
            </div>
            <hr>
            <p>Total <span class="price" style="color:black"><b id="cart-total"></b></span></p>
          </div>
          
          <script>
            const checkoutButton = document.getElementById('checkout-button');
      const cartCountElement = checkoutButton.querySelector('.badge');
      
      function getCartItemCount() {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      let count = 0;
      for (let i = 0; i < cart.length; i++) {
        count += cart[i].quantity;
      }
      return count;
      }
           cartCountElement.textContent =getCartItemCount();
            document.addEventListener('DOMContentLoaded', function() {
              // Get cart items from localStorage
              var cart = JSON.parse(localStorage.getItem('cart')) || [];
              // Get cart count element
              var cartCount = document.getElementById('cart-count');
              cartCount.innerHTML = cart.length;
              // Get cart items element
              var cartItems = document.getElementById('cart-items');
              cartItems.innerHTML = '';
              // Loop through cart items and create HTML for each item
              var total = 0;
              cart.forEach(function(item, index) {
      var html = '<p><a href="#">' + item.productName + '</a>  </p><span class="quantity">QTY' + item.quantity + '</span> <span class="price">$' + item.price + '</span> <button class="delete-btn" data-index="' + index + '">Delete</button></p>';
      cartItems.innerHTML += html;
      total += parseFloat(item.price);
    }); 
    var cartTotal = document.getElementById('cart-total');
    cartTotal.innerHTML = total;
    cartCountElement.textContent =getCartItemCount();
             
// Add event listener to delete buttons
    var deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(function(button) {
      button.addEventListener('click', function(event) {
        var index = parseInt(button.dataset.index);
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        location.reload();
        cartCountElement.textContent =getCartItemCount();
      });
    });
  });
          </script>

<script>
    $(document).ready(function() {
      // Listen for the form submission
      $('#checkout-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally
    
        // Get the form values
        var formData = {
          'fname': $('input[name=fname]').val(),
          'address': $('input[name=address]').val(),
          'city': $('input[name=city]').val(),
          'cardname': $('input[name=cardname]').val(),
          'cardnumber': $('input[name=cardnumber]').val(),
          'expmonth': $('input[name=expmonth]').val(),
          'expyear': $('input[name=expyear]').val(),
          'cvv': $('input[name=cvv]').val()
        };
    
        // Get the cart items
        var cart = JSON.parse(localStorage.getItem('cart')) || [];
    
        // Combine the form data and cart items into one object
        var data = {
          'form_data': formData,
          'cart_items': cart
        };
    
        // Send the data to the backend using AJAX
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
          type: 'POST',
          url: '/cartproducts/checkout',
          data: data,
          dataType: 'json',
          success: function(response) {
            // Handle success response from the backend
            console.log(response);
            localStorage.clear();
          },
          error: function(xhr, status, error) {
            // Handle error response from the backend
            console.log(error);
          }
        });
      });
    });
    
    </script>
    <script>
      
      </script>
    </div>
  </div>
</x-app-layout>