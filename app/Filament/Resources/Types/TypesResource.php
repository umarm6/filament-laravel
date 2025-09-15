<?php

namespace App\Filament\Resources\Types;

use App\Filament\Resources\Types\Pages\CreateTypes;
use App\Filament\Resources\Types\Pages\EditTypes;
use App\Filament\Resources\Types\Pages\ListTypes;
use App\Filament\Resources\Types\Schemas\TypesForm;
use App\Filament\Resources\Types\Tables\TypesTable;
use App\Models\ProductType;
use App\Models\Types;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TypesResource extends Resource
{
    protected static ?string $model = ProductType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $recordTitleAttribute = 'ProductType';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 0 ? 'primary' : 'info';
    }

    protected static ?string $navigationLabel = 'Types';


    public static function form(Schema $schema): Schema
    {
        return TypesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TypesTable::configure($table);
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
            'index' => ListTypes::route('/'),
        ];
    }
}
