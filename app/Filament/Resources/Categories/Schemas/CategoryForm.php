<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextInput::make('slug')
                //     ->required(),
                TextInput::make('name')
                    ->label('Category Name')
                    ->helperText('The name of the category')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
