<?php

namespace App\Filament\Resources\Categories;

use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Filament\Resources\Categories\Schemas\CategoriesForm;
use App\Filament\Resources\Categories\Tables\CategoriesTable;
use App\Models\ProductCategories;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CategoriesResource extends Resource
{
    protected static ?string $model = ProductCategories::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $recordTitleAttribute = 'Categories';
    protected static ?string $navigationLabel = 'Categories';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 0 ? 'primary' : 'info';
    }


    public static function form(Schema $schema): Schema
    {
        return CategoriesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
          ];
    }

     public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Category Name')
                    ->weight('bold'),
                TextEntry::make('description')->placeholder('No description.'),
                TextEntry::make('external_url')
                    ->visible(fn($record) => !empty($record->external_url))
                    ->label('External URL')
                    ->formatStateUsing(
                        fn($state) => $state
                            ? '<a href="' . e($state) . '" target="_blank" class="text-primary-600 underline">' . e($state) . '</a>'
                            : ''
                    )
                    ->html(),
                TextEntry::make('productTypes.name')
                    ->label('Product Types')
                    ->listWithLineBreaks()
                    ->badge()
                    ->color('success'),

                TextEntry::make('products_count')
                    ->label('Products Count')
                    ->formatStateUsing(fn($record) => $record->products()->count())
                    ->badge(),
            ])
             ->columns(1);
    }
}
