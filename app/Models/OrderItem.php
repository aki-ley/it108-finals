<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Specify the table if it's different from the default 'order_items'
    protected $table = 'order_items';
    protected $primaryKey = 'order_item_id';

    // Define which attributes are mass assignable
    protected $fillable = [
        'order_id',
        'product_id',
        'size',
        'quantity',
        'price',
    ];

    // Relationship with the Order model
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    // Define the relationship to the Product model
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
