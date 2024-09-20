<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductDetailPage extends Component
{
    public $slug;


    public function render()
    {

        $product = Product::slug($this->slug)->firstOrFail();

        return view('livewire.product-detail-page',[
            'product' => $product
        ])->title(__('Product Detail'));
    }
}
