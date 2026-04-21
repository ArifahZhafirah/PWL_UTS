<?php

namespace App\Filament\Admin\Resources\Penjualans;

use App\Filament\Admin\Resources\Penjualans\Pages\CreatePenjualan;
use App\Filament\Admin\Resources\Penjualans\Pages\EditPenjualan;
use App\Filament\Admin\Resources\Penjualans\Pages\ListPenjualans;
use App\Filament\Admin\Resources\Penjualans\Schemas\PenjualanForm;
use App\Models\Penjualan;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PenjualanResource extends Resource
{
    protected static ?string $model = Penjualan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'penjualan_kode';

    protected static ?string $navigationLabel = 'Penjualan';

    protected static ?string $pluralModelLabel = 'Penjualan';

    protected static ?string $modelLabel = 'Penjualan';

    public static function form(Schema $schema): Schema
    {
        return PenjualanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.nama')
                    ->label('User')
                    ->searchable(),

                TextColumn::make('pembeli')
                    ->label('Pembeli')
                    ->searchable(),

                TextColumn::make('penjualan_kode')
                    ->label('Kode Penjualan')
                    ->searchable(),

                TextColumn::make('total_terjual')
                    ->label('Terjual')
                    ->getStateUsing(fn ($record) => $record->detailPenjualan->sum('jumlah')),

                TextColumn::make('penjualan_tanggal')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenjualans::route('/'),
            'create' => CreatePenjualan::route('/create'),
            'edit' => EditPenjualan::route('/{record}/edit'),
        ];
    }
}