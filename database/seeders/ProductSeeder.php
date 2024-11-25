<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('products')->truncate();
        $categories = Category::all();
        foreach($categories as $category){
            Product::factory()->count(3)->create([
                    'category_id' => $category->id,
                    'is_active' => true,
                    'is_featured' => true,
                    'in_stock' => true,
                    'on_sale' => true,
                ]
            );
        }
    }

}
