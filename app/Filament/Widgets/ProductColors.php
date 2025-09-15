<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use ProductColorsWidget;

class ProductColors extends TableWidget
{

    protected static ?int $sort = 2;


    public function table(Table $table): Table
    {
            return $table
            ->query(fn (): Builder => \App\Models\ProductColors::query())
            ->columns([
                    TextColumn::make('name'),
                    ColorColumn::make('hex_code')
            ])->defaultPaginationPageOption(5);
    }

}
