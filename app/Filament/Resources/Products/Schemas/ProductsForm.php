<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\ProductCategories;
use App\Models\ProductColors;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Name')->required(),
            Textarea::make('description')->label('Description')->columnSpan(2),
            Select::make('product_category_id')->label('Category')
                ->options(ProductCategories::query()->pluck('name', 'id')),
            Select::make('product_color_id')->label('Color')
                ->options(ProductColors::query()->pluck('name', 'id'))

        ]);
    }
}
