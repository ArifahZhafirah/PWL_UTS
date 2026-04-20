<?php

namespace App\Filament\Admin\Resources\Penjualans\Pages;

use App\Filament\Admin\Resources\Penjualans\PenjualanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPenjualan extends EditRecord
{
    protected static string $resource = PenjualanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
