<?php

namespace App\Filament\Admin\Resources\Barangs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'kategori_nama')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('barang_kode')
                    ->label('Kode Barang')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(10),
                TextInput::make('barang_nama')
                    ->label('Nama Barang')
                    ->required()
                    ->maxLength(100),
                TextInput::make('harga_beli')
                    ->numeric()
                    ->required(),
                TextInput::make('harga_jual')
                    ->numeric()
                    ->required(),
            ]);
    }
}
