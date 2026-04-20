<?php

namespace App\Filament\Admin\Resources\Stoks\Pages;

use App\Filament\Admin\Resources\Stoks\StokResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStoks extends ListRecords
{
    protected static string $resource = StokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
