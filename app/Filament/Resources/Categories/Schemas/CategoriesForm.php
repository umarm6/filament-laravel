<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoriesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Name')->required(),
                Textarea::make('description')->label('Description')->columnSpan(2),
                TextInput::make('external_url')->url()->label('External Url')->nullable(),
                Select::make('product_type_ids')
                    ->label('Product Types')
                    ->required()
                    ->multiple()
                    ->relationship('productTypes', 'name')
                    ->preload()
                    ->searchable()
                    ->native(false)->columnSpanFull(),
            ])->columns(1);
    }
}
