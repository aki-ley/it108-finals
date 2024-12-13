<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade'); // Explicitly reference 'user_id'
            $table->decimal('total_price', 10, 2);
            $table->string('payment_status', 50)->nullable();
            $table->string('delivery_status', 50)->nullable();
            $table->foreignId('shipping_address_id')->constrained('shipping_addresses', 'shipping_address_id')->onDelete('cascade'); // Explicitly reference 'shipping_address_id'
            $table->timestamps(0); // Timestamp columns
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
