<?php

namespace App\Filament\Admin\Resources\Suppliers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('supplier_kode')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(10),
                TextInput::make('supplier_nama')
                    ->required()
                    ->maxLength(100),
                TextInput::make('supplier_alamat')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
