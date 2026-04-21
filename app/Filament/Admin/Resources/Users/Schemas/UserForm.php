<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('level_id')
                    ->label('Level')
                    ->relationship('level', 'level_nama')
                    ->required(),

                TextInput::make('username')
                    ->required()
                    ->maxLength(20),

                TextInput::make('nama')
                    ->required()
                    ->maxLength(100),

                TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
            ]);
    }
}