<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Wishlist;


use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{

    public function index()
    {
        return view('user.home');
    }

    public function redirect()
    {
        $user = Auth::user(); // Get the logged-in user

        if (!$user) {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

        switch ($user->usertype) {
            case 'admin':
                return view('admin.home');
            case 'seller':
                return view('seller.home');
            default:
                return $this->index();
        }
    }


    public function viewshoes(){

        $products = DB::table('products')->get();

        return view ('user.shop', compact('products'));
    }

    public function showProductDetails($product_id)
    {
        $product = DB::table('products')->where('product_id', $product_id)->first();

        if (!$product) {
            return redirect('/shop_page')->with('error', 'Product not found.');
        }

        return view('user.product_details', ['product' => $product]);
    }


    public function add_wishlist(Request $request)
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to add items to your wishlist.');
        }
    
        $userId = Auth::id();
        $productId = $request->input('product_id'); // Get the product ID from the form
    
        // Validate if the product exists
        $product = DB::table('products')->where('product_id', $productId)->first();
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }
    
        // Check if the product is already in the user's wishlist
        $existingWishlistItem = DB::table('wishlists')
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    
        if ($existingWishlistItem) {
            return redirect()->back()->with('message', 'This product is already in your wishlist.');
        }
    
        // Add the product to the wishlist using a raw query
        DB::table('wishlists')->insert([
            'user_id' => $userId,
            'product_id' => $productId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->back()->with('message', 'Product added to wishlist successfully!');
    }

    public function view_wishlist()
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to view your wishlist.');
        }
    
        $userId = Auth::id();
    
        // Retrieve wishlist items with product details
        $wishlistItems = DB::table('wishlists')
            ->join('products', 'wishlists.product_id', '=', 'products.product_id') // Join with products table
            ->where('wishlists.user_id', $userId)
            ->select('products.product_id', 'products.product_title', 'products.price', 'products.image1', 'wishlists.wishlist_id') // Select necessary product details
            ->get();
    
        return view('user.wishlist', compact('wishlistItems'));
    }



    public function add_cart(Request $request, $product_id)
    {
        if (Auth::id()) {
            $user = Auth::user();
            $product = Product::find($product_id);
            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }

            $cart = new Cart;

            $size = $request->size;
            if (strlen($size) > 10) {
                $size = substr($size, 0, 10); // Truncate to 10 characters
            }

            $cart->user_id = $user->user_id;
            $cart->product_title = $product->product_title;
            $cart->price = $product->price;
            $cart->image1 = $request->selected_image;
            $cart->product_id = $product->product_id;
            $cart->quantity = $request->quantity;
            $cart->size = $request->size;

            $cart->save();

            return redirect()->back()->with('success', 'Product added to cart successfully!');
        } else {
            return redirect()->route('login')->with('error', 'Please log in to add items to the cart.');
        }
    }

    public function show_cart()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cartItems = Cart::where('user_id', $user->user_id)->get(); // Get all cart items for the logged-in user
            return view('user.cart', compact('cartItems'));
        } else {
            return redirect()->route('login')->with('error', 'Please log in to view your cart.');
        }
    }

    
}

