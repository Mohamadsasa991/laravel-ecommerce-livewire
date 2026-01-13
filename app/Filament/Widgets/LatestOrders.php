<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Order;

class LatestOrders extends TableWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at','desc')
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->label('Order ID'),

                    TextColumn::make('user.name')
                    ->searchable(),

                    TextColumn::make('grand_total')
                    ->money('usd'),

                    TextColumn::make('status')
                    ->badge(),

                    TextColumn::make('payment_method')
                    ->sortable()
                    ->searchable(),

                    TextColumn::make('payment_status')
                    ->sortable()
                    ->searchable()
                    ->badge(),

                    TextColumn::make('created_at')
                    ->label('Order_date')
                    ->dateTime()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
             Action::make('View Order')
                ->url(fn(\App\Models\Order $order) => OrderResource::getUrl('view',['record' => $order]
                ))
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
