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

//userpage
// Route::get('/userpage', [HomeController::class, 'viewshoes']);

//shoes
Route::get('/shop', [HomeController::class, 'viewshoes']);
