<?php

namespace App\Livewire;

use App\Helpers\CartManegment;
use App\Livewire\Partials\Navbar;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart Page')]
class CartPage extends Component
{

    public $cart_items = [];
    public $grand_total;

    public function mount(){
        $this->cart_items = CartManegment::GetCartItemsFromCookie();
        $this->grand_total = CartManegment::calculateGrandTotal($this->cart_items);

    }

    public function removeItem($product_id){
        $this->cart_items = CartManegment::removeCartItem($product_id);
        $this->grand_total = CartManegment::calculateGrandTotal($this->cart_items);
        $this->dispatch('update-cart-count' ,total_count:count($this->cart_items))->to(Navbar::class);
    }

    public function increaseQty($product_id) {
        $this->cart_items = CartManegment::incrementQuantityToCartItem($product_id);
        $this->grand_total = CartManegment::calculateGrandTotal($this->cart_items);
    }

    public function decreaseQty($product_id){
        $this->cart_items = CartManegment::decrementQuantityToCartItem($product_id);
        $this->grand_total = CartManegment::calculateGrandTotal($this->cart_items);
    }
    public function render()
    {
        return view('livewire.cart-page');
    }
}
