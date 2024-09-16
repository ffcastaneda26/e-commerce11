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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete()->comment('Orden o Pedido');
            $table->string('first_name')->nullable()->comment('Nombre');
            $table->string('last_name')->nullable()->comment('Apelido');
            $table->string('phone',15)->nullable()->comment('Teléfono');
            $table->string('street_address')->nullable()->comment('Calle y Número');
            $table->string('city')->nullable()->comment('Ciudad');
            $table->string(column: 'state')->nullable()->comment('Entidad');
            $table->string(column: 'country')->nullable()->comment('País');
            $table->string('zip_code',5)->nullable()->comment('Código Postal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
