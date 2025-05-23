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
            $table->id();
            $table->foreignId('order_client_id')->constrained('order_clients')->cascadeOnDelete();
            $table->string('product_name');
            $table->integer('quantity');
            $table->float('price');
            $table->tinyInteger('status')->default(0)->comment('0 - pending, 1 - accepted, 2 - delivered, 3 - cancelled');
            $table->text('notes')->nullable();
            $table->timestamps();
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
