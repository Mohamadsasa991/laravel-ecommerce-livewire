<?php

namespace App\Livewire;

use App\Helpers\CartManegment;
use App\Mail\OrderPlaced;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;


class CheckOutPage extends Component
{
    #[Title('Checkout Page')]

    public $first_name,$last_name,$street_address
    ,$city,$state,$zip_code,$payment_method,$phone;


        public function mount(){
         $cart_items = CartManegment::GetCartItemsFromCookie();
         if(count($cart_items)==0){
            return redirect('products');
         }
        }

    public function placeOrder(){
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'payment_method' => 'required',
        ]);

        $cart_items = CartManegment::GetCartItemsFromCookie();
        $line_items = [];
        foreach($cart_items as $item){
            $line_items [] =[
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $item['unit_amount'] * 100,
                    'product_data' => [
                        'name' => $item['quantity']
                    ],
                ],
                'quantity' => $item['quantity']
            ];
        }

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->grand_total = CartManegment::calculateGrandTotal($cart_items);

        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status = 'new';
        $order->currency = 'usd';
        $order->shipping_amount = 0;
        $order->shipping_method = 'none';
        $order->notes = 'Order list by '.Auth::user()->name;

        $address = new Address();
        $address->first_name = $this->first_name;
        $address->last_name = $this->last_name;

        $address->phone = $this->phone;

        $address->city = $this->city;

        $address->state = $this->state;
        $address->zip_code = $this->zip_code;
        $address->street_address = $this->street_address;

        $redirect_url = '';
        if($this->payment_method ==='stripe'){
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $sessionCheckout = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => Auth::user()->email,
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => route('success') . '/?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel')
            ]);
            $redirect_url = $sessionCheckout->url;
        }
        else {
            $redirect_url = route('success');
       }
       $order->save();
       $address->order_id = $order->id;
       $address->save();
       $order->items()->createMany($cart_items);
       CartManegment::ClearCartItems();
       Mail::to(request()->user())->send(new OrderPlaced($order));
       return redirect($redirect_url);
    }
    public function render()
    {
        $cart_items = CartManegment::GetCartItemsFromCookie();
        $grand_total = CartManegment::calculateGrandTotal($cart_items);

        return view('livewire.check-out-page',[
        'cart_items' => $cart_items,
        'grand_total' => $grand_total
        ]);
    }
}
