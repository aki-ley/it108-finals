<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Order extends Model
{
    //
    use HasFactory;

    protected $primaryKey = 'order_id'; // Define the primary key


    protected $fillable = [
        'user_id',
        'total_price',
        'payment_status',
        'delivery_status',
    ];



    
}
