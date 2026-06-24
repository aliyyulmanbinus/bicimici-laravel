<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Fieldset::make('Details')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    FileUpload::make('thumbnail')
                        ->required()
                        ->image(),
                ]),

                Fieldset::make('Additional')
                ->schema([
                    Repeater::make('benefits')
                        ->relationship('benefits')
                        ->schema([
                            TextInput::make('name')
                                ->required(),
                        ]),

                    Textarea::make('about')
                        ->required(),
                    
                    Select::make('is_popular')
                        ->options([
                            true => 'Popular',
                            false => 'Not Popular',
                        ])
                        ->required(),

                    Select::make('category_id')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                ]),
                // TextInput::make('slug')
                //     ->required(),
                // TextInput::make('name')
                //     ->required(),
                // TextInput::make('thumbnail')
                //     ->required(),
                // Textarea::make('about')
                //     ->required()
                //     ->columnSpanFull(),
                // Toggle::make('is_popular')
                //     ->required(),
                // Select::make('category_id')
                //     ->relationship('category', 'name')
                //     ->required(),
            ]);
    }
}
