<?php

namespace App\Filament\Admin\Resources\Stoks\Pages;

use App\Filament\Admin\Resources\Stoks\StokResource;
use App\Models\Barang;
use Filament\Resources\Pages\CreateRecord;

class CreateStok extends CreateRecord
{
    protected static string $resource = StokResource::class;

    protected function afterCreate(): void
    {
        $stok = $this->record;

        $barang = Barang::find($stok->barang_id);

        if ($barang) {
            $barang->stok_total += $stok->stok_jumlah;
            $barang->save();
        }
    }
}