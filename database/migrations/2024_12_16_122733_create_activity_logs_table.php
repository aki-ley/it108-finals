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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->string('usertype')->nullable(); // Replaces `user_id` to log the user's type
            $table->string('action_performed'); // INSERT, UPDATE, DELETE
            $table->string('table_name'); // Name of the table where the action occurred
            $table->string('column_data'); // Column name associated with the action
            $table->timestamps(0); // Timestamps for when the log was created
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
