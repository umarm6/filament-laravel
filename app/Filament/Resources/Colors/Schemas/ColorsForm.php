<?php

namespace App\Filament\Resources\Colors\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ColorsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Name')->required(),
                Textarea::make('description')->label('Description')->columnSpanFull(),
                ColorPicker::make('hex_code')->label('Color')->required()->hexColor(),
            ]);
    }
}
