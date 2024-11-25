<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::factory()->create();
        // for($i=1;$i<=5,$i++){
        //     $image = 'brands/brand_' . str_pad($i,3,0,STR_PADLEFT);
        //     $name = 'Marca ' . $i;
        //     Brand::factory()->create([
        //         'name'  => $name,
        //         'image' => $image,
        //     ]);
        // }

    }
}
