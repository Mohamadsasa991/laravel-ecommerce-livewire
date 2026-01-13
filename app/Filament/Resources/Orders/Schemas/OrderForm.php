<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class OrderForm
{
public static function configure(Schema $schema): Schema
{
return $schema->components([

Group::make()
->columnSpanFull() // الفورم يمتد بعرض كامل الصفحة
->schema([

    // Order Information
    Section::make('Order Information')->schema([

        Select::make('user_id')
            ->label('Customer')
            ->relationship('user', 'name')
            ->required()
            ->preload()
            ->searchable(),

        Select::make('payment_method')
            ->options([
                'stripe' => 'Stripe',
                'cod' => 'Cash on Delivery',
            ])
            ->required(),

        Select::make('payment_status')
            ->options([
                'pending' => 'Pending',
                'paid' => 'Paid',
                'failed' => 'Failed',
            ])
            ->default('pending')
            ->required(),

        ToggleButtons::make('status')
            ->options([
                'new' => 'New',
                'processing' => 'Processing',
                'shipped' => 'Shipped',
                'delivered' => 'Delivered',
                'cancelled' => 'Cancelled',
            ])
            ->inline()
            ->default('new')
            ->required()
            ->colors([
                'new' => 'info',
                'processing' => 'warning',
                'shipped' => 'success',
                'delivered' => 'success',
                'cancelled' => 'danger',
            ])
            ->icons([
                'new' => 'heroicon-m-sparkles',
                'processing' => 'heroicon-m-arrow-path',
                'shipped' => 'heroicon-m-truck',
                'delivered' => 'heroicon-m-check-badge',
                'cancelled' => 'heroicon-m-x-circle',
            ]),

        Select::make('currency')
            ->options([
                'inr' => 'INR',
                'usd' => 'USD',
                'eur' => 'EUR',
            ])
            ->default('usd')
            ->required(),

        Select::make('shipping_method')
            ->options([
                'fedex' => 'Fedex',
                'ups' => 'UPS',
                'dhl' => 'DHL',
                'usps' => 'USPS',
            ]),

        Textarea::make('notes')
            ->columnSpanFull(),

    ])->columns(2),

    // Order Items
    Section::make('Order Items')->schema([

        Repeater::make('items')
            ->relationship('items')
            ->reactive()
            ->afterStateUpdated(function (Get $get, Set $set) {
                $total = collect($get('items') ?? [])->sum(fn($item) => $item['total_amount'] ?? 0);
                $set('grand_total', $total);
            })
            ->schema([
                Grid::make(4)->schema([

                    Select::make('product_id')
                        ->label('Product')
                        ->relationship('product', 'name')
                        ->searchable()
                        ->reactive()
                        ->preload()
                        ->afterStateUpdated(fn ($state, Set $set) =>
                            $set('unit_amount', Product::find($state)?->price ?? 0)
                        )
                        ->required()
                        ->disableOptionsWhenSelectedInSiblingRepeaterItems(),

                    TextInput::make('quantity')
                        ->numeric()
                        ->default(1)
                        ->reactive()
                        ->afterStateUpdated(function ($state, Set $set, Get $get) {
                            $set('total_amount', $state * $get('unit_amount'));
                        })
                        ->required(),

                    TextInput::make('unit_amount')
                        ->numeric()
                        ->disabled()
                        ->dehydrated()
                        ->reactive(),

                    TextInput::make('total_amount')
                        ->numeric()
                        ->disabled()
                        ->dehydrated()
                        ->required(),

                ]),
            ])
            ->defaultItems(1)
            ->addActionLabel('Add Item')
            ->columnSpanFull(),

        Placeholder::make('grand_total_display')
            ->label('Grand Total')
            ->content(function (Get $get) {
                $total = collect($get('items') ?? [])->sum(fn($item) => $item['total_amount'] ?? 0);
                return '$' . number_format($total, 2);
            })
            ->columnSpanFull(),

        Hidden::make('grand_total')
            ->reactive()
            ->dehydrated(),

    ]),

]),

]);
}
}
