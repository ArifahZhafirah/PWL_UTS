<?php

namespace App\Filament\Admin\Resources\PenjualanDetails;

use App\Filament\Admin\Resources\PenjualanDetails\Pages\CreatePenjualanDetail;
use App\Filament\Admin\Resources\PenjualanDetails\Pages\EditPenjualanDetail;
use App\Filament\Admin\Resources\PenjualanDetails\Pages\ListPenjualanDetails;
use App\Filament\Admin\Resources\PenjualanDetails\Schemas\PenjualanDetailForm;
use App\Filament\Admin\Resources\PenjualanDetails\Tables\PenjualanDetailsTable;
use App\Models\PenjualanDetail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class PenjualanDetailResource extends Resource
{
    protected static ?string $model = PenjualanDetail::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Penjualan Detail';

    public static function form(Schema $schema): Schema
    {
        return PenjualanDetailForm::configure($schema);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('penjualan.penjualan_kode')
                ->label('Kode Penjualan')
                ->searchable(),

            Tables\Columns\TextColumn::make('barang.barang_nama')
                ->label('Barang')
                ->searchable(),

            Tables\Columns\TextColumn::make('harga')
                ->money('IDR')
                ->label('Harga'),

            Tables\Columns\TextColumn::make('jumlah')
                ->label('Jumlah'),

            Tables\Columns\TextColumn::make('subtotal')
                ->money('IDR')
                ->label('Subtotal'),
                ])
        ->recordActions([
            EditAction::make(),
        ])
        ->bulkActions([
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ]);
}

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenjualanDetails::route('/'),
            'create' => CreatePenjualanDetail::route('/create'),
            'edit' => EditPenjualanDetail::route('/{record}/edit'),
        ];
    }
}
