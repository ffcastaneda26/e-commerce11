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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete()->comment('Orden o Pedido');
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete()->comment('Producto');
            $table->integer('quantity')->default(1)->comment('Cantidad');
            $table->decimal('unit_amount',10,2)->nullable()->comment('Costo unitario');
            $table->decimal('total_amount',10,2)->nullable()->comment('Importe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
