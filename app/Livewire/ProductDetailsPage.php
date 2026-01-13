<?php

namespace App\Livewire;

use App\Helpers\CartManegment;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProductDetailsPage extends Component
{
    #[Title('Product Details Page')]

    public $slug;

    public $quantity = 1;
    public function decreaseQty(){
        if($this->quantity > 1 )
        $this->quantity--;
    }


    public function increaseQty(){
        $this->quantity++;
    }


    public function addToCart($product_id) {
        $total_count = CartManegment::addItemToCartWithQty($product_id ,$this->quantity);

        $this->dispatch('update-cart-count', total_count:$total_count)->to(Navbar::class);
    }

    public function mount($slug){
        $this->slug = $slug;
    }
    public function render()
    {
        $product = Product::where('slug' , $this->slug)->firstOrFail();
        return view('livewire.product-details-page',['product' => $product]);
    }
}
