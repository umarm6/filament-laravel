<?php

namespace App\Filament\Resources\Products\Tables;

use App\Jobs\ChangeProductTitleJob;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable(),
                TextColumn::make('description')->label('Description')->limit(30),
                TextColumn::make('category.name')->label('Category')->sortable()->searchable(),
                TextColumn::make('color.name')->label('Color')->sortable()->searchable(),
                TextColumn::make('created_at')->label('Created At')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->label('Updated At')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('processProductTitle')
                    ->label('Update title Job')
                    ->icon('heroicon-m-arrow-path')
                    ->action(function ($record) {
                        ChangeProductTitleJob::dispatch($record->id);

                        Notification::make()
                            ->success()
                            ->title('Product Processed')
                            ->body("Product '{$record->name}' was processed.")
                            ->persistent()
                            ->sendToDatabase(auth()->user());
                    })
                    ->color('primary'), // Optional button color
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
