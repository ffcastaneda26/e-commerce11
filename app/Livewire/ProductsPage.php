<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProductsPage extends Component
{
    #[Url]
      public $selected_categories = [];
    #[Url]
      public $selected_brands = [];
    #[Url]
    public $featured;
    #[Url]
    public $price_range;
    #[Url]
    public $on_sale;
    #[Url]
    public $sort = 'latest';
    public $min_price;
    public $max_price;
    public $step_price = 50;
    public function render()
    {
        $this->max_price = Product::max('price');
        $this->min_price = Product::min('price');

        $productQuery =Product::query()->isActive();
        if(!empty($this->selected_categories)){
            $productQuery->whereIn('category_id',$this->selected_categories);
        }
        if(!empty($this->selected_brands)){
            $productQuery->whereIn('brand_id',$this->selected_brands);
        }

        if($this->featured){
            $productQuery->isFeature();
        }
        if($this->on_sale){
            $productQuery->onSale();
        }

        if($this->price_range){
            $productQuery->whereBetween('price',[0,$this->price_range]);
        }

        if($this->sort == 'latest'){
            $productQuery->latest();
        }

        if($this->sort == 'price'){
            $productQuery->orderBy('price');
        }

        $products = $productQuery->paginate(9);

        return view('livewire.products-page',[
            'products' =>  $products,
            'brands'    => Brand::isActive()->get(),
            'categories'=>Category::isActive()->get()
        ])->title(__('Products'));
    }

    // Agregar producto al carrito
    public function addToCart($product_id){
        $total_count = CartManagement::addItemToCart($product_id);
        $this->dispatch('update-cart-count',total_count:$total_count)->to(Navbar::Class);
    }

    public function removeCart(){
        CartManagement::clearCartItems();
        $this->dispatch('update-cart-count',total_count:0)->to(Navbar::Class);
        // TODO:: Agregar el componente de mensajes
    }


}
