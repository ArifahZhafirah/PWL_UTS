<?php

namespace App\Filament\Admin\Resources\Stoks;

use App\Filament\Admin\Resources\Stoks\Pages\CreateStok;
use App\Filament\Admin\Resources\Stoks\Pages\EditStok;
use App\Filament\Admin\Resources\Stoks\Pages\ListStoks;
use App\Filament\Admin\Resources\Stoks\Schemas\StokForm;
use App\Models\Stok;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StokResource extends Resource
{
    protected static ?string $model = Stok::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'stok_id';

    protected static ?string $navigationLabel = 'Stok';

    protected static ?string $pluralModelLabel = 'Stok';

    protected static ?string $modelLabel = 'Stok';

    public static function form(Schema $schema): Schema
    {
        return StokForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('supplier.supplier_nama')
                    ->label('Supplier')
                    ->searchable(),

                TextColumn::make('barang.barang_nama')
                    ->label('Barang')
                    ->searchable(),

                TextColumn::make('user.nama')
                    ->label('User')
                    ->searchable(),

                TextColumn::make('stok_tanggal')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i'),

                TextColumn::make('stok_jumlah')
                    ->label('Jumlah'),
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
            'index' => ListStoks::route('/'),
            'create' => CreateStok::route('/create'),
            'edit' => EditStok::route('/{record}/edit'),
        ];
    }
}