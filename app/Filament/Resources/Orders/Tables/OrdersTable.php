<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable()
                    ->label('Customer'),

                TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->money('usd')
                    ->getStateUsing(fn($record) => $record->grand_total ?? $record->items->sum('total_amount')),

                TextColumn::make('payment_method')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('payment_status')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('currency')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('shipping_method')
                    ->sortable()
                    ->searchable(),

                SelectColumn::make('status')
                    ->options([
                       'new' => 'New',
                'processing' => 'Processing',
                'shipped' => 'Shipped',
                'delivered' => 'Delivered',
                'cancelled' => 'Cancelled',
                    ])
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
