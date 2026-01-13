<x-mail::message>
# Order Placed successfully !

Thanks you for your order , your order number is :{{$order->id}}

<x-mail::button :url="$url">
Your Order Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
