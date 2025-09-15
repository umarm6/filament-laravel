<?php

namespace App\Filament\Widgets;

use App\Models\ProductCategories;
use App\Models\Products;
use App\Models\ProductType;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardWidgetStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make('Total Products', Products::count())
                ->description('All products in the system')
                ->color('primary')
                ->icon('heroicon-o-cube'),
            Stat::make('Total Product Types', ProductType::count())
                ->description('Products Types in the system')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
            Stat::make('Categories', ProductCategories::count())
                ->description('Unique product categories')
                ->color('info')
                ->icon('heroicon-o-folder'),
         ];
    }
}
