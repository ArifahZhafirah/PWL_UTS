<?php

namespace App\Filament\Admin\Resources\Kategoris\Schemas;

use Dom\Text;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KategoriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kategori_kode')
                    ->label('Kode Kategori')
                    ->required()
                    ->maxLength(10),
                TextInput::make('kategori_nama')
                    ->label('Nama Kategori')    
                    ->required()
                    ->maxLength(100),
            ]);
    }
}
