<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Attributes\Title;
use Livewire\Component;

class OrderDetailsPage extends Component
{
    #[Title('Order Details Page')]

    public $order_id;

    public function mount($order_id){
        $this->order_id = $order_id;
    }
    public function render()
    {
        $orderItems = OrderItem::with('product')->where('order_id',$this->order_id)->get();
        $address = Address::where('order_id',$this->order_id)->first();
        $order = Order::where('id', $this->order_id)->first();
        return view('livewire.order-details-page',[
            'order_items' => $orderItems,
            'address' => $address,
            'order' => $order
        ]);
    }
}
