<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;

class ProductDetailPage extends Component
{
    // use LivewireAlert;
    public $slug;
    public $quantity=1;


    public function render()
    {
        $product = Product::slug($this->slug)->firstOrFail();
        return view('livewire.product-detail-page',[
            'product' => $product
        ])->title(__('Product Detail'));
    }


    public function increaseQty(){
        $this->quantity++;
    }

    public function decreaseQty(){
        if($this->quantity > 1){
            $this->quantity--;
        }
    }

    public function removeCart(){
        CartManagement::clearCartItems();
        $this->dispatch('update-cart-count',total_count:0)->to(Navbar::Class);
        // TODO:: Agregar el componente de mensajes
    }

    public function addToCart($product_id){
        $total_count = CartManagement::addItemToCartWithQty($product_id,$this->quantity);
        $this->dispatch('update-cart-count',total_count:$total_count)->to(Navbar::Class);
        // TODO:: Agregar el componente de mensajes
    }
}
