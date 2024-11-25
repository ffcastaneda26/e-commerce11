<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('categories')->truncate();

        for($i=1;$i<=10;$i++){
            $image = 'categories/categoria' . $i . '.png';
            $name = 'Categoria ' . $i;
            Category::factory()->create([
                'name'  => $name,
                'image' => $image,
                'slug'  => 'categoria-'.$i,
            ]);
        }

        for($i=1;$i<=5;$i++){
            $image = 'categories/category_' . str_pad($i,3,0,STR_PAD_LEFT) . '.jpg';
            $name = 'Categoria  ' . $i+10;
            Category::factory()->create([
                'name'  => $name,
                'image' => $image,
                'slug'  => 'category-'.$i+10,
            ]);
        }

    }
}
