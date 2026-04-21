<?php

namespace App\Filament\Admin\Resources\Stoks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StokForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('supplier_id')
                    ->label('Supplier')
                    ->relationship('supplier', 'supplier_nama')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('barang_id')
                    ->label('Barang')
                    ->relationship('barang', 'barang_nama')
                    ->searchable()
                    ->preload()
                    ->required(),

                Hidden::make('user_id')
                    ->default(7),

                DateTimePicker::make('stok_tanggal')
                    ->label('Tanggal Stok')
                    ->required(),

                TextInput::make('stok_jumlah')
                    ->label('Jumlah Stok')
                    ->numeric()
                    ->required(),
            ]);
    }
}