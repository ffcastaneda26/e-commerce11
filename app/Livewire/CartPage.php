<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;

class CartPage extends Component
{
    public $cart_items =[];
    public $grand_total = 0;
    public $tax_percentage = 16;

    public $taxes = 0;
    public $shipping = 0;
    public $total_to_pay = 0;

    public function mount(){
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
        $this->calculate_totals();

    }

    public function render()
    {
        return view('livewire.cart-page')->title(__('Cart'));
    }

    // Eliminar Entrada del Carrito
    public function removeItem($product_id){
        $this->cart_items = CartManagement::removeCartItem($product_id);
        $this->calculate_totals();
        $this->dispatch('update-cart-count',total_count:count($this->cart_items))->to(Navbar::Class);
    }

    private function calculate_totals(){
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
        $this->taxes = round($this->grand_total * $this->tax_percentage / 100,2);
        $this->total_to_pay = round($this->grand_total + $this->taxes + $this->shipping,2);
    }

    public function increaseQty($product_id){
        $this->cart_items = CartManagement::incrementQuantityToCartItem($product_id);
        $this->calculate_totals();
    }

    public function decreaseQty($product_id){
        $this->cart_items = CartManagement::decrementQuantityToCartItem($product_id);
        $this->calculate_totals();
    }
}
