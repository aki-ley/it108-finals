<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\Auth\GoogleAuthController;

// Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Google login routes
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

// Redirect based on user type
Route::get('/redirect', [HomeController::class, 'redirect']);
//seller route

Route::get('/view_product', [SellerController::class, 'view_product']);

//add product
Route::post('/add_product', [SellerController::class, 'add_product'])->name('add_product');

//showing product
Route::get('/show_product', [SellerController::class, 'show_product']);

//shop page
Route::get('/shop_page', [HomeController::class, 'viewshoes']);
    
//product details
Route::get('/product_details/{id}', [HomeController::class, 'showProductDetails']);

//add wishlist
Route::post('/wishlist', [HomeController::class, 'add_wishlist'])->name('wishlist.add');
Route::get('/wishlist', [HomeController::class, 'view_wishlist'])->name('wishlist.view');
Route::delete('/remove_wishlist/{id}', [HomeController::class, 'remove_wishlist'])->name('remove_wishlist');


//add to cart
Route::post('/add_cart/{id}', [HomeController::class, 'add_cart']);

//display cart
Route::get('/show_cart', [HomeController::class, 'show_cart'])->name('showcart.view');

//remove cart
Route::delete('/remove_cart/{id}', [HomeController::class, 'remove_cart'])->name('remove_cart');

