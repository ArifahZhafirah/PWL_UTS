<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'm_barang';
    protected $primaryKey = 'barang_id';

    protected $fillable = [
        'kategori_id',
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual',
    ];

    // Tambahkan ini agar stok_total bisa di-eager load & sortable
    protected $appends = ['stok_total'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function stok()
    {
        return $this->hasMany(Stok::class, 'barang_id');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(PenjualanDetail::class, 'barang_id');
    }

    // Accessor: stok masuk - stok keluar
    public function getStokTotalAttribute(): int
    {
        $masuk = $this->stok()->sum('stok_jumlah');
        $keluar = $this->detailPenjualan()->sum('jumlah');
        return max(0, $masuk - $keluar);
    }
}