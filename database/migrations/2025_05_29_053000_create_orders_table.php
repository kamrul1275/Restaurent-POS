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
            $table->string('order_number')->unique();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->decimal('subtotal', 10, 2)->after('customer_phone');
            $table->decimal('discount_percent', 5, 2)->default(0)->after('subtotal');
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_method', ['Cash', 'Card', 'Mobile Banking']);
            $table->enum('order_type', ['dine_in', 'takeaway', 'delivery'])->default('dine_in');
            $table->text('delivery_address')->nullable();
            $table->decimal('delivery_charge', 8, 2)->default(0);
            $table->enum('order_status', ['pending', 'preparing', 'ready', 'delivered', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->date('order_date');
            $table->index('order_date');
            $table->index('order_status');
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
