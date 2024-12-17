<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'user_id',
        'product_id',
        'product_title',
        'image1',
        'quantity',
        'size',
        'price',
        'order_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}