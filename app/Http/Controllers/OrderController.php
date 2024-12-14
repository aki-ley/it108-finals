<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->user_id;
    
            // Validate the input fields from the checkout form
            $validated = $request->validate([
                'your_name' => 'required|string|max:255',
                'email' => 'required|email',
                'address' => 'required|string|max:255',
                'region' => 'required|string',
                'province' => 'required|string',
                'city' => 'required|string',
                'barangay' => 'required|string',
                'phoneno' => 'required|string|max:15',
                'payment_method' => 'required|string|max:50',
            ]);
    
            // Call the calculate_cart_total function using a raw SQL query
            $totalPrice = DB::selectOne('SELECT calculate_cart_total(?) AS total', [$user_id]);
    
            // If no total price is returned, default to 0
            $totalPrice = $totalPrice ? $totalPrice->total : 0;
    
            // Add delivery fee
            $shippingFee = 300;
            $totalAmount = $totalPrice + $shippingFee;
    
            // Create the order
            $order = Order::create([
                'user_id' => $user->user_id,
                'total_price' => $totalAmount,
                'payment_status' => 'Pending',
                'delivery_status' => 'Pending',
                'testVar' => 'Test value',
            ]);
    
            // Save the order details (delivery info)
            $orderDetails = OrderDetail::create([
                'order_id' => $order->order_id,
                'name' => $request->your_name,
                'email' => $request->email,
                'address' => $request->address,
                'region' => $request->region,
                'province' => $request->province,
                'city' => $request->city,
                'barangay' => $request->barangay,
                'phone' => $request->phoneno,
                'payment_method' => $request->payment_method,
            ]);
    
            // Empty the user's cart after the order is placed
            Cart::where('user_id', $user->user_id)->delete();
    
            // Redirect back with success message and necessary data
            return view('user.checkout', [
                'message' => 'Your order has been placed successfully.',
                'totalPrice' => $totalPrice,
                'shippingFee' => $shippingFee,
                'totalAmount' => $totalAmount,
            ]);
        }
    
        // If not logged in, redirect to login page
        return redirect()->route('login')->with('error', 'Please log in to place an order.');
    }
    
}

