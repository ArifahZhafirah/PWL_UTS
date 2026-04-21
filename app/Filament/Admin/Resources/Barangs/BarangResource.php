<?php

namespace App\Filament\Admin\Resources\Barangs;

use App\Filament\Admin\Resources\Barangs\Pages\CreateBarang;
use App\Filament\Admin\Resources\Barangs\Pages\EditBarang;
use App\Filament\Admin\Resources\Barangs\Pages\ListBarangs;
use App\Filament\Admin\Resources\Barangs\Schemas\BarangForm;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'barang_nama';

    public static function form(Schema $schema): Schema
    {
        return BarangForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kategori.kategori_nama')
                    ->label('Kategori')
                    ->searchable(),

                TextColumn::make('barang_kode')
                    ->label('Kode Barang')
                    ->searchable(),

                TextColumn::make('barang_nama')
                    ->label('Nama Barang')
                    ->searchable(),

                TextColumn::make('harga_beli')
                    ->label('Harga Beli')
                    ->money('IDR', true),

                TextColumn::make('harga_jual')
                    ->label('Harga Jual')
                    ->money('IDR', true),

                // Stok sekarang tampil dari accessor
                TextColumn::make('stok_total')
                    ->label('Sisa Stok')
                    ->getStateUsing(fn ($record) => $record->stok_total)
                    ->badge()
                    ->color(fn ($state) => match(true) {
                        $state <= 0  => 'danger',
                        $state <= 5  => 'warning',
                        default      => 'success',
                    }),
            ])
            ->actions([
    Action::make('edit')
        ->label('Edit')
        ->icon('heroicon-o-pencil-square')
        ->url(fn ($record) => static::getUrl('edit', ['record' => $record])), // ← TAMBAH KOMA DI SINI

    // Action jual dengan modal input jumlah
    Action::make('jual')
        ->label('Jual')
        ->icon('heroicon-o-shopping-cart')
        ->color('success')
        ->form([
            TextInput::make('pembeli')
                ->label('Nama Pembeli')
                ->required()
                ->maxLength(100),

            TextInput::make('jumlah')
                ->label('Jumlah Terjual')
                ->numeric()
                ->minValue(1)
                ->required(),
        ])
    ->action(function (array $data, $record) {
        $jumlah = (int) $data['jumlah'];
        $sisaStok = $record->stok_total;

        // Validasi stok mencukupi
        if ($jumlah > $sisaStok) {
            Notification::make()
                ->title('Stok tidak mencukupi!')
                ->body("Stok tersedia hanya {$sisaStok}.")
                ->danger()
                ->send();
            return;
        }

        // Generate kode penjualan otomatis, contoh: PJL-20260421-0001
        $kode = 'PJL-' . now()->format('Ymd') . '-' . str_pad(
            Penjualan::whereDate('penjualan_tanggal', today())->count() + 1,
            4, '0', STR_PAD_LEFT
        );

        // Buat record penjualan
        $penjualan = Penjualan::create([
            'user_id'           => Auth::id(),
            'pembeli'           => $data['pembeli'],
            'penjualan_kode'    => $kode,
            'penjualan_tanggal' => now(),
        ]);

        // Buat detail penjualan → stok otomatis berkurang
        PenjualanDetail::create([
            'penjualan_id' => $penjualan->penjualan_id,
            'barang_id'    => $record->barang_id,
            'harga'        => $record->harga_jual,
            'jumlah'       => $jumlah,
        ]);

        Notification::make()
            ->title('Penjualan berhasil!')
            ->body("{$jumlah} {$record->barang_nama} dijual ke {$data['pembeli']}. Sisa stok: " . ($sisaStok - $jumlah))
            ->success()
            ->send();
    })
    ->modalHeading(fn ($record) => "Jual: {$record->barang_nama}")
    ->modalDescription(fn ($record) => "Stok tersedia: {$record->stok_total} unit")
    ->modalSubmitActionLabel('Proses Penjualan'),
            ])
           ->bulkActions([
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
            'index'  => ListBarangs::route('/'),
            'create' => CreateBarang::route('/create'),
            'edit'   => EditBarang::route('/{record}/edit'),
        ];
    }
}