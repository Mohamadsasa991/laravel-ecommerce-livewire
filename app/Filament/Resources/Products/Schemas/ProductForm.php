<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur:true)
                    ->afterStateUpdated(fn(string $operation ,$state ,Set $set)
                     => $operation ==='create'|| $operation==='edit' ? $set('slug',Str::slug($state)) :null)
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->unique(Product::class,'slug',ignoreRecord:true)
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(255),
                FileUpload::make('images')
                    ->multiple()
                    ->directory('products')
                    ->maxFiles(5)
                    ->reorderable(),
                MarkdownEditor::make('description')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                    Select::make('category_id')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->relationship('category','name'),
                      Select::make('brand_id')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->relationship('brand','name'),
                Toggle::make('is_active')
                    ->required()
                    ->default(true),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('in_stock')
                    ->required()
                    ->default(true),
                Toggle::make('on_sale')
                    ->required(),
            ]);
    }
}
