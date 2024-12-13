<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

        return view ('user.shoes', compact('products'));
    }
}
