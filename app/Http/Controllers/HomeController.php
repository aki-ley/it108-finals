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
        // Fetch data from the 'popular_products' view
        $popularProducts = DB::table('popular_products')->get();


        // Return the data to the view called 'user.home'
        return view('user.home', compact('popularProducts')); // Use 'popularProducts' instead of 'popular'

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
    
        // Call the table-valued function to get wishlist items for the logged-in user
        $wishlistItems = DB::select('SELECT * FROM getWishlistProducts(?)', [$userId]);
    
        // Pass the results to the view
        return view('user.wishlist', compact('wishlistItems'));
    }

    public function remove_wishlist($wishlist_id)
    {
        if (Auth::check()) {
            $user_id = Auth::id();
    
            // Ensure the wishlist item belongs to the logged-in user
            $wishlist = Wishlist::where('wishlist_id', $wishlist_id)
                                ->where('user_id', $user_id)
                                ->first();
    
            if ($wishlist) {
                $wishlist->delete();
                return redirect()->back()->with('message', 'Product removed from wishlist');
            } else {
                return redirect()->back()->with('error', 'Product not found or does not belong to you.');
            }
        } else {
            return redirect()->route('login')->with('error', 'Please log in to manage your wishlist.');
        }
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
            $cart->image1 = $request->image1;
            $cart->product_id = $product->product_id;
            $cart->quantity = $request->quantity;
            $cart->size = $request->size;

            $cart->save();

            return redirect()->back()->with('message', 'Product added to cart successfully!');
        } else {
            return redirect()->route('login')->with('error', 'Please log in to add items to the cart.');
        }
    }

    public function show_cart()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->user_id;

            // Call the calculate_cart_total function using a raw SQL query
            $totalPrice = DB::selectOne('SELECT calculate_cart_total(?) AS total', [$user_id]);

            $cartItems = Cart::where('user_id', $user_id)->get(); // Get all cart items for the logged-in user

            return view('user.cart', compact('cartItems', 'totalPrice'));
        } else {
            return redirect()->route('login')->with('error', 'Please log in to view your cart.');
        }
    }
    public function remove_cart($cart_id)
    {
        if (Auth::check()) {
            $user_id = Auth::id();
    
            // Ensure the cart item belongs to the logged-in user
            $cart = Cart::where('cart_id', $cart_id)->where('user_id', $user_id)->first();
    
            if ($cart) {
                $cart->delete();
                return redirect()->back()->with('message', 'Product removed from cart');
            } else {
                return redirect()->back()->with('error', 'Product not found or does not belong to you.');
            }
        } else {
            return redirect()->route('login')->with('error', 'Please log in to manage your cart.');
        }
    }
    
    public function checkout()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->user_id;
    
            // Call the calculate_cart_total function using a raw SQL query
            $totalPrice = DB::selectOne('SELECT calculate_cart_total(?) AS total', [$user_id]);
    
            // Retrieve all cart items for the logged-in user
            $cartItems = Cart::where('user_id', $user_id)->get();
    
            // Check if the cart is empty
            if ($cartItems->isEmpty()) {
                // Redirect back with a message if the cart is empty
                return redirect()->back()->with('error', 'Your cart is empty. Please add items to the cart.');
            }
    
            // If no total price is returned, default to 0
            $totalPrice = $totalPrice ? $totalPrice->total : 0;
    
            // Add shipping fee (if applicable)
            $shippingFee = 300;
            $totalAmount = $totalPrice + $shippingFee;
    
            return view('user.checkout', compact('cartItems', 'totalPrice', 'shippingFee', 'totalAmount'));
        } else {
            return redirect()->route('login')->with('error', 'Please log in to checkout.');
        }
    }
    
    

 
    
}

