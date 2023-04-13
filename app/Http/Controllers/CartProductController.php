<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
class CartProductController extends Controller
{
    public function index($categoryId)
    {
        $query = Product::query();
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        $products = $query->paginate(10);
        return view('cartproduct.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::find($id);
        return view('cartproduct.show', ['product' => $product]);
    }

    public function placeorder()
    {
        return view('cartproduct.placeorder');
    }

    public function checkout(Request $request)
    {
        
        // Validate request data
        // $validatedData = $request->validate([
        //     'firstname' => 'required|max:255',
        //     'address' => 'required|max:255',
        //     'city' => 'required|max:255',
        //     'cardname' => 'required|max:255',
        //     'cardnumber' => 'required|numeric',
        //     'expmonth' => 'required|max:255',
        //     'expyear' => 'required|numeric',
        //     'cvv' => 'required|numeric',
        //     'cart_items.*.productName' => 'required|max:255',
        //     'cart_items.*.price' => 'required|numeric',
        //     'cart_items.*.quantity' => 'required|numeric',
        // ]);

        $formData = $request->input('form_data');
        $cartItems = $request->input('cart_items');
        $order = new Order;
        $user = Auth::user();
        $order->user_Id=$user->id;
        $order->order_number='1';
        $order->customer_name = $formData['fname'];
        $order->order_Address = $formData['address'];
        $order->order_city = $formData['city'];
        $order->name_oncard = $formData['cardname'];
        $order->creditCardNumber = $formData['cardnumber'];
        $order->ExpireDate = $formData['expyear'] + $formData['expmonth'];
        $order->CVV = $formData['cvv'];
        $order->save();

        // Loop through cart items and create order details
        $total = 0;
        foreach($cartItems as $cartItem) {
            $orderDetail = new OrderDetail;
            $orderDetail->order_id = $order->id;
            $orderDetail->product_name = $cartItem['productName'];
            $orderDetail->unit_price = $cartItem['price'];
            $orderDetail->quantity = $cartItem['quantity'];
            $orderDetail->save();
        }
        return response()->json(['success' => true]);
    }
}
