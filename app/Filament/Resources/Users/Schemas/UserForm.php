<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                ->required(),
                TextInput::make('email')
                ->required()
                ->email()
                ->maxLength(255)
                ->unique(ignoreRecord:true),
                TextInput::make('password')
                ->password()
                ->revealable()
                ->maxLength(255)
                 ->dehydrated(fn ($state) => filled($state))
            ]);
    }
}
