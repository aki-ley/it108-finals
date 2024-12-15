<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopularProduct extends Model
{
    // Specify the table name (the view name)
    protected $table = 'popular_products';

    // If the view does not have timestamps, disable them
    public $timestamps = false;

    // Define the fillable attributes if needed
    protected $fillable = [
        'product_id',
        'product_title',
        'cart_count',
        'wishlist_count',
        'order_count',
        'price',
        'image1',
    ];
}