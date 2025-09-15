<?php

namespace App\Filament\Resources\Colors\Tables;

use App\Models\ProductColors;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ColorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable(),
                TextColumn::make('hex_code')->label('Hex Code')->searchable(),
                ColorColumn::make('color_code_color')
                    ->label('Color')
                    ->toggleable()
                    ->alignment(Alignment::Center)
                    ->getStateUsing(fn(ProductColors $record): string => $record->hex_code),
                TextColumn::make('products_count')
                    ->label('Products Count')
                    ->badge()
                    ->alignment(Alignment::Center)
                    ->color(fn($state) => $state == 0 ? 'gray' : 'primary')
                    ->counts('products')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('created_at')->label('Created At')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->label('Updated At')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
