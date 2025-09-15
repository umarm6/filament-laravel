<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Resources\Products\Schemas\ProductsForm;
use App\Filament\Resources\Products\Tables\ProductsTable;
use App\Models\Products;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Table;

class ProductsResource extends Resource
{
    protected static ?string $model = Products::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 0 ? 'primary' : 'info';
    }


    protected static ?string $recordTitleAttribute = 'Products';

    public static function form(Schema $schema): Schema
    {

        return ProductsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
        ->components([
                Section::make('Product Overview')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Product Name')
                            ->weight('bold')
                            ->size('lg'),

                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull()
                            ->markdown()
                            ->prose(),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),
                Section::make('Details')
                    ->schema([
                        TextEntry::make('category.name')
                            ->label('Category')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('color.hex_code')
                            ->label('Color')
                            ->formatStateUsing(fn($state) => "<span class='inline-block w-6 h-6 rounded border-none' style='background-color: $state;'></span>")
                            ->html(),

                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime('d M Y')
                            ->badge(),
                    ])
                    ->columns(3)
                    ->columnSpanFull()
                    ->collapsible(),
                Section::make('Custom Status Bar')
                    ->schema([
                        ViewEntry::make('custom_status_bar')
                            ->view('filament.infolists.components.status-bar'),
                    ])->columnSpanFull()
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
        ];
    }
}
