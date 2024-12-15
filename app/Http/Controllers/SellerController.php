<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class SellerController extends Controller
{
    // Check if the user is authenticated in each method without middleware

    public function view_product()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect to login if not authenticated
        }

        return view('seller.product');
    }

    public function add_product(Request $request)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect to login if not authenticated
        }

        // Your existing logic to handle image uploads
        $image1 = null;
        $image2 = null;
        $image3 = null;

        if ($request->hasFile('image1')) {
            $file1 = $request->file('image1');
            $image1 = time() . '_1.' . $file1->getClientOriginalExtension();
            $file1->move('product', $image1);
        }

        if ($request->hasFile('image2')) {
            $file2 = $request->file('image2');
            $image2 = time() . '_2.' . $file2->getClientOriginalExtension();
            $file2->move('product', $image2);
        }

        if ($request->hasFile('image3')) {
            $file3 = $request->file('image3');
            $image3 = time() . '_3.' . $file3->getClientOriginalExtension();
            $file3->move('product', $image3);
        }

        DB::insert(
            'INSERT INTO products (product_title, description, price, quantity, image1, image2, image3, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())',
            [
                $request->product_title,
                $request->description,
                $request->price,
                $request->quantity,
                $image1,
                $image2,
                $image3
            ]
        );

        return redirect()->back()->with('message', 'Product Added Successfully!');
    }

    public function show_product()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect to login if not authenticated
        }

        $products = DB::table('products')->get();
        return view('seller.show_product', compact('products'));
    }

    public function removeProduct($product_id)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect to login if not authenticated
        }

        DB::table('products')->where('product_id', $product_id)->delete();
        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    public function show_orders()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect to login if not authenticated
        }

        // Fetch order summary data from the view
        $orders = DB::table('order_details_view')->get();
        return view('seller.show_orders', compact('orders'));
    }

    public function delivered($order_id)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect to login if not authenticated
        }

        // Fetch the order from the view
        $order = DB::table('order_details_view')->where('order_id', $order_id)->first();
    
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }
    
        // Update the delivery and payment status in the `orders` table
        DB::table('orders')->where('order_id', $order_id)->update([
            'delivery_status' => 'delivered',
            'payment_status' => 'Paid',
        ]);
    
        return redirect()->back()->with('success', 'Order marked as delivered.');
    }
}
