<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersAndAddOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Remove the foreign key constraint and column from the orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['shipping_address_id']); // Drop the foreign key constraint
            $table->dropColumn('shipping_address_id');    // Drop the column
        });

        // Now drop the shipping_addresses table
        Schema::dropIfExists('shipping_addresses');

        // Create the order_details table
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('order_detail_id');
            $table->foreignId('order_id')->constrained('orders', 'order_id')->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('address');
            $table->string('region');
            $table->string('province');
            $table->string('city');
            $table->string('barangay');
            $table->string('phone', 15);
            $table->string('payment_method');
            $table->timestamps(0); // Timestamp columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Recreate the shipping_addresses table
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id('shipping_address_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->text('address');
            $table->string('city', 100);
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100);
            $table->timestamps(0);
        });

        // Re-add the shipping_address_id column to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('shipping_address_id')->nullable()->constrained('shipping_addresses', 'shipping_address_id')->onDelete('cascade');
        });

        // Drop the order_details table
        Schema::dropIfExists('order_details');
    }
}

