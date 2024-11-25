<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $name = fake()->words(3, true);
        $slug = Str::slug($name);
        return [
            'category_id'   => Category::inRandomOrder()->first()->id,
            'brand_id'      => Brand::inRandomOrder()->first()->id,
            'name'          => $name,
            'slug'         =>  $slug,
            'images' => [
                'products/product1.webp',
                'products/product2.webp',
                'products/product3.webp',
                'products/product4.webp',
                'products/product5.webp',
                'products/product6.webp',
                'products/product7.webp',
                'products/product8.webp',
                'products/product9.webp',
                'products/product10.webp',
                ],
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 10, 100),
            'is_active' => fake()->boolean(),
            'is_featured' => fake()->boolean(),
            'in_stock' => fake()->boolean(),
            'on_sale' => fake()->boolean(),

        ];
    }
}
