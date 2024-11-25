<?php

use App\Models\Category;
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
   
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete()->comment('Categoría');
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete()->comment('Marca');
            $table->string('name',100)->comment('Nombre');
            $table->string('slug')->unique()->comment('Slug');
            $table->json('images')->nullable()->comment('Imágenes');
            $table->longText('description')->comment('Descripción');
            $table->decimal('price',10,2)->default(1.00)->comment('Precio');
            $table->boolean('is_active')->default(true)->comment('¿Activo?');
            $table->boolean('is_featured')->default(false)->comment('¿Futuro?');
            $table->boolean('in_stock')->default(true)->comment('¿En Existencia?');
            $table->boolean(column: 'on_sale')->default(false)->comment(comment: '¿En Venta?');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
