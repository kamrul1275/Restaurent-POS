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
        Schema::create('menu_items', function (Blueprint $table) {
        $table->id();
        $table->string('name', 100);
        $table->foreignId('menu_category_id')->constrained();
        $table->decimal('price', 8, 2);
        $table->decimal('cost_price', 8, 2)->nullable();
        $table->text('description')->nullable();
        $table->string('image')->nullable();
        $table->boolean('is_available')->default(true);
        $table->boolean('is_active')->default(true); // To indicate if the item is active
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
