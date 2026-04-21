<?php

namespace App\Filament\Admin\Resources\PenjualanDetails\Pages;

use App\Filament\Admin\Resources\PenjualanDetails\PenjualanDetailResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePenjualanDetail extends CreateRecord
{
    // INI YANG KURANG - penyebab error utama
    protected static string $resource = PenjualanDetailResource::class;
}