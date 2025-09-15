<?php

namespace App\Filament\Resources\Types\Schemas;

use App\Models\ProductType;
use App\Services\VocusApiService;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Livewire\Form;

class TypesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')->required(),
                TextInput::make('api_unique_number')
                    ->required()
                    ->disabled()
                    ->label('API Unique Identifier')
                    ->maxLength(100)
                    ->suffixAction(
                        Action::make('fetchApiNumber')
                             ->icon('heroicon-o-arrow-path')
                            ->action(function (Set $set) {
                                $uniqueId = (new VocusApiService())->fetchApiUniqueNumber();

                                 if (str_contains($uniqueId, ' ')) {
                                     Notification::make()
                                         ->title('Failed to fetch API number')
                                         ->body($uniqueId)
                                         ->danger()
                                         ->persistent()
                                         ->send();
                                     return $set;
                                 }

                                $set('api_unique_number',$uniqueId);

                            })
                    )
        ]);
    }
}
