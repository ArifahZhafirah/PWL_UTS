<?php

namespace App\Filament\Admin\Resources\Penjualans\Schemas;

use App\Models\Barang;
use App\Models\MUser;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PenjualanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('User')
                    ->options(MUser::pluck('nama', 'user_id'))
                    ->searchable()
                    ->required(),

                TextInput::make('pembeli')
                    ->label('Pembeli')
                    ->required()
                    ->maxLength(100),

                TextInput::make('penjualan_kode')
                    ->label('Kode Penjualan')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20),

                DateTimePicker::make('penjualan_tanggal')
                    ->label('Tanggal Penjualan')
                    ->required(),

                Repeater::make('detailPenjualan')
                    ->label('Detail Penjualan')
                    ->relationship('detailPenjualan')
                    ->schema([
                        Select::make('barang_id')
                            ->label('Barang')
                            ->relationship('barang', 'barang_nama')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live(),

                        Hidden::make('harga')
                            ->default(0)
                            ->dehydrated(true),

                        TextInput::make('jumlah')
                            ->label('Jumlah Barang Dibeli')
                            ->numeric()
                            ->required(),
                    ])
                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                        $barang = Barang::find($data['barang_id']);
                        $data['harga'] = $barang?->harga_jual ?? 0;

                        return $data;
                    })
                    ->columns(2)
                    ->defaultItems(1),
            ]);
    }
}