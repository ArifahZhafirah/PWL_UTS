<?php

namespace App\Filament\Admin\Resources\Suppliers;

use App\Filament\Admin\Resources\Suppliers\Pages\CreateSupplier;
use App\Filament\Admin\Resources\Suppliers\Pages\EditSupplier;
use App\Filament\Admin\Resources\Suppliers\Pages\ListSuppliers;
use App\Filament\Admin\Resources\Suppliers\Schemas\SupplierForm;
use App\Models\Supplier;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'supplier_nama';

    protected static ?string $navigationLabel = 'Supplier';

    protected static ?string $pluralModelLabel = 'Supplier';

    protected static ?string $modelLabel = 'Supplier';

    public static function form(Schema $schema): Schema
    {
        return SupplierForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('supplier_kode')
                    ->label('Kode Supplier')
                    ->searchable(),

                TextColumn::make('supplier_nama')
                    ->label('Nama Supplier')
                    ->searchable(),

                TextColumn::make('supplier_alamat')
                    ->label('Alamat Supplier')
                    ->searchable(),
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
            'index' => ListSuppliers::route('/'),
            'create' => CreateSupplier::route('/create'),
            'edit' => EditSupplier::route('/{record}/edit'),
        ];
    }
}