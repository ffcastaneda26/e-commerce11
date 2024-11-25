<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('brands')->truncate();
        for($i=1;$i<=5;$i++){
            $image = 'brands/brand_' . str_pad($i,3,0,STR_PAD_LEFT) . '.webp';
            $name = 'Marca ' . $i;
            Brand::factory()->create([
                'name'  => $name,
                'image' => $image,
            ]);
        }

    }
}
