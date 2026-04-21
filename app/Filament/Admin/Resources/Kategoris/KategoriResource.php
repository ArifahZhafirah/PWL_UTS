<?php

namespace App\Filament\Admin\Resources\Kategoris;

use App\Filament\Admin\Resources\Kategoris\Pages\CreateKategori;
use App\Filament\Admin\Resources\Kategoris\Pages\EditKategori;
use App\Filament\Admin\Resources\Kategoris\Pages\ListKategoris;
use App\Filament\Admin\Resources\Kategoris\Schemas\KategoriForm;
use App\Models\Kategori;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KategoriResource extends Resource
{
    protected static ?string $model = Kategori::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'kategori_nama';

    protected static ?string $navigationLabel = 'Kategori';

    protected static ?string $pluralModelLabel = 'Kategori';

    protected static ?string $modelLabel = 'Kategori';
    
    public static function form(Schema $schema): Schema
    {
        return KategoriForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kategori_kode')
                    ->label('Kode Kategori')
                    ->searchable(),

                TextColumn::make('kategori_nama')
                    ->label('Nama Kategori')
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
            'index' => ListKategoris::route('/'),
            'create' => CreateKategori::route('/create'),
            'edit' => EditKategori::route('/{record}/edit'),
        ];
    }
}