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
    // Get the authenticated user
    $user = Auth::user();

    // Fetch the user's cart items
    $cartItems = Cart::where('user_id', $user->user_id)->get();

    // Check if there are items in the cart
    if ($cartItems->isEmpty()) {
        // Flash a message and redirect back to the checkout page
        session()->flash('message', 'Your cart is empty.');
        return redirect()->route('user.checkout');  // Replace 'checkout.page' with your actual route name for the checkout page
    }

    // Calculate the total price
    $totalPrice = $cartItems->sum(function($cart) {
        return $cart->price * $cart->quantity;
    });

        $totalQuantity = $cartItems->sum('quantity'); // Sum of quantities in the cart
        $size = $cartItems->first()->size;
    
        // Create a new order with total price and total quantity
    $order = Order::create([
        'user_id' => $user->user_id,
        'total_price' => $totalPrice,
        'quantity' => $totalQuantity, // Add quantity to the order
        'payment_status' => 'Pending', // Default value, you can adjust
        'delivery_status' => 'Pending', // Default value, you can adjust
        'size' => $size,
    ]);

    // Move cart items to the order by updating the 'order_id' field
    foreach ($cartItems as $cart) {
        $cart->update(['order_id' => $order->order_id]);
    }
    
        // Delete the items from the cart
        Cart::where('user_id', $user->user_id)->delete();

    // Insert delivery information into the OrderDetails table
    OrderDetail::create([
        'order_id' => $order->order_id,
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'address' => $request->input('address'),
        'region' => $request->input('region'),
        'province' => $request->input('province'),
        'city' => $request->input('city'),
        'barangay' => $request->input('barangay'),
        'phone' => $request->input('phone'),
        'payment_method' => $request->input('payment_method')
    ]);

    // Return a success message
    return redirect()->route('checkout.result');
}

public function checkout_result(){

    $checkoutResult = DB::table('order_details')->first();


    return view('user.checkout_result', compact('checkoutResult'));
}
    
public function order_page()
{
    // Fetch order summary data from the view
    $userOrderSummaries = DB::table('order_details_view')->get();

    // Dump the data to inspect the structure
    // dd($userOrderSummaries);

    // Pass the data to the view
    return view('user.order_page', compact('userOrderSummaries'));
}
}
