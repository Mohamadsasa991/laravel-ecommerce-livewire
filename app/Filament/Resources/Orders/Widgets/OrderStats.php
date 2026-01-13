<?php

namespace App\Filament\Resources\Orders\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Number;

class OrderStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New Orders',Order::where('status','new')->count()),
            Stat::make('Orders Processing',Order::where('status','pocessing')->count()),
            Stat::make('Orders Shipped',Order::where('status','shipping')->count()),
            Stat::make('Average Price',Number::currency(Order::avg('grand_total'),'usd')),
        ];
    }
}
