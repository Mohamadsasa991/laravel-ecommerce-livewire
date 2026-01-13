<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Filament\Resources\Orders\Widgets\OrderStats;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use function PHPUnit\Framework\returnArgument;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets():array{
        return [
            OrderStats::class
        ];
    }

    public function getTabs():array{
        return [
            null => Tab::make('All'),
            'New' => Tab::make()->query(fn($query) =>$query->where('status','new')),
              'Processing' => Tab::make()->query(fn($query) =>$query->where('status','processing')),
              'Shipped' => Tab::make()->query(fn($query) =>$query->where('status','shipped')),
              'Delivered' => Tab::make()->query(fn($query) =>$query->where('status','delivered')),
              'Canceled' => Tab::make()->query(fn($query) =>$query->where('status','canceled')),
        ];
    }

    //  protected function getFooterWidgets():array{
    //     return [
    //         OrderStats::class
    //     ];
    // }
}
