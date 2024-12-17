<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
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
            session()->flash('message', 'Your cart is empty.');
            return redirect()->route('user.checkout'); 
        }
    
        // Calculate the total price for the order
        $totalPrice = $cartItems->sum(function($cart) {
            // Fetch the product price
            $product = Product::find($cart->product_id);
            return $product ? $product->price * $cart->quantity : 0;
        });

          // Initialize the shipping fee
            $shippingFee = 300;

            // Add the shipping fee to the total price
            $totalAmount = $totalPrice + $shippingFee;
    
        // Get the size from the cart (assuming all items in the cart have the same size for simplicity)
        $size = $cartItems->first()->size;
    
        // Create a new order with total price and other order details
        $order = Order::create([
            'user_id' => $user->user_id,
            'total_price' => $totalAmount,
            'payment_status' => 'Pending', // Default value
            'delivery_status' => 'Pending', // Default value
        ]);
    
        // Insert items into the order_items table
        foreach ($cartItems as $cart) {
            // Fetch the product price for each cart item
            $product = Product::find($cart->product_id);
            $price = $product ? $product->price : 0;
    
            // Insert order item with price
            OrderItem::create([
                'order_id' => $order->order_id,
                'product_id' => $cart->product_id,
                'size' => $cart->size,
                'quantity' => $cart->quantity,
                'price' => $price,
            ]);
        }
    
        // Delete the items from the cart
        Cart::where('user_id', $user->user_id)->delete();
    
        // Insert delivery information into the order_details table
        OrderDetail::create([
            'order_id' => $order->order_id,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'region' => $request->input('full_region'),
            'province' => $request->input('full_province'),
            'city' => $request->input('full_city'),
            'barangay' => $request->input('full_barangay'),
            'phone' => $request->input('phone'),
            'payment_method' => $request->input('payment_method')
        ]);
    
        // Store the order ID in the session for future reference if needed
        session(['order_id' => $order->order_id]);
    
        // Return to the order success page or view
        return redirect()->route('checkout.result');
    }
    

public function checkout_result(Request $request)
{
    // Retrieve the order_id from the session
    $orderId = session('order_id');

    // Fetch the order details for the given order_id
    $checkoutResult = DB::table('order_details')->where('order_id', $orderId)->first();

    // Pass the order details to the view
    return view('user.checkout_result', compact('checkoutResult'));
}
    
public function order_page()
{
    $user_id = Auth::id();

    $userOrderSummaries = DB::select('SELECT * FROM user_orders_view1 WHERE user_id = ?', [$user_id]);

    foreach ($userOrderSummaries as $summary) {
        $summary->products = [];
        $images = explode(', ', $summary->product_images);
        $titles = explode(', ', $summary->product_titles);
        $sizes = explode(', ', $summary->sizes);
        $prices = explode(', ', $summary->product_prices);
        $quantities = explode(', ', $summary->quantities);

        foreach ($images as $index => $image) {
            $productTitle = $titles[$index];
            $size = $sizes[$index];
            $price = $prices[$index];
            $quantity = $quantities[$index];

            if (!isset($summary->products[$productTitle])) {
                $summary->products[$productTitle] = [
                    'image' => $image,
                    'sizes' => [],
                    'quantities' => [],
                    'price' => $price,
                ];
            }

            $summary->products[$productTitle]['sizes'][$size] =
                ($summary->products[$productTitle]['sizes'][$size] ?? 0) + $quantity;
        }
    }

    return view('user.order_page', compact('userOrderSummaries'));
}



}
