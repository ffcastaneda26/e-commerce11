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
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('Usuario/Cliente');
            $table->decimal('grand_total',10,2)->nullable()->comment('Total de la orden');
            $table->string('payment_method')->nullable()->comment('Forma de pago');
            $table->string('payment_status')->nullable()->comment('Estado del pago');
            $table->enum('status',['new','processing','shippend','delivered','canceled'])->default('new')->coment('Estado de la orden');
            $table->string('currency')->nullable()->comment('Moneda');
            $table->decimal('shipping_amount',10,2)->nullable()->comment('Cargo x Entrega');
            $table->string('shipping_method')->nullable()->comment('Forma de entrega');
            $table->text('notes')->nullable()->comment('Notas');
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
