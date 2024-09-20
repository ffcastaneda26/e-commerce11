<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class ProductsPage extends Component
{
    public function render()
    {
        $products = Product::query()->isActive();
        return view('livewire.products-page',[
            'products' => $products->paginate(10),
            'brands'    => Brand::isActive()->get(),
            'categories'=>Category::isActive()->get()
        ])->title(__('Products'));
    }
}
