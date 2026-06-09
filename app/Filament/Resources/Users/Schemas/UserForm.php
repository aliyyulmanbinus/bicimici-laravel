<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('password')
                    ->helperText('Minimum 9 characters')
                    ->password()
                    ->required()
                    ->minLength(9)
                    ->maxLength(255),

                Select::make('occupation')
                ->options([
                    'Developer' => 'Developer',
                    'Designer' => 'Designer',
                    'Project Manager' => 'Project Manager',
                ])
                ->required(),

                Select::make('roles')
                    ->label('Role')
                    ->required()
                    ->relationship('roles', 'name'),

                FileUpload::make('photo')
                ->required()
                ->image(),
                
            ]);
    }
}
