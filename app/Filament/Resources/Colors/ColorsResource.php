<?php

namespace App\Filament\Resources\Colors;

use App\Filament\Resources\Colors\Pages\CreateColors;
use App\Filament\Resources\Colors\Pages\EditColors;
use App\Filament\Resources\Colors\Pages\ListColors;
use App\Filament\Resources\Colors\Schemas\ColorsForm;
use App\Filament\Resources\Colors\Tables\ColorsTable;
use App\Models\ProductColors;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ColorsResource extends Resource
{
    protected static ?string $model = ProductColors::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaintBrush;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 0 ? 'primary' : 'info';
    }

    protected static ?string $recordTitleAttribute = 'Colors';

    protected static ?string $navigationLabel = 'Colors';

    public static function form(Schema $schema): Schema
    {
        return ColorsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ColorsTable::configure($table);
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
            'index' => ListColors::route('/'),
        ];
    }

}
