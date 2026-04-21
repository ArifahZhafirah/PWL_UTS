<?php

namespace App\Filament\Admin\Resources\PenjualanDetails\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PenjualanDetailForm
{
    public static function configure(Schema $schema): Schema
{
    return $schema
        ->components([
            Select::make('penjualan_id')
                ->label('Kode Penjualan')
                ->relationship('penjualan', 'penjualan_kode')
                ->preload()
                ->required(),

            Select::make('barang_id')
                ->label('Barang')
                ->relationship('barang', 'barang_nama')
                ->preload()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $barang = \App\Models\Barang::find($state);

                    if ($barang) {
                        $set('harga', $barang->harga_jual);
                    }
                })
                ->required(),

            TextInput::make('harga')
                ->numeric()
                ->required()
                ->readOnly(),

            TextInput::make('jumlah')
                ->numeric()
                ->required(),
        ])
        ->columns(2);
}
}
