<?php

namespace App\Models;

use App\Models\User;
use App\Models\PenjualanDetail;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 't_penjualan';

    protected $primaryKey = 'penjualan_id';

    protected $fillable = [
        'user_id',
        'pembeli',
        'penjualan_kode',
        'penjualan_tanggal',
    ];

    protected $casts = [
        'penjualan_tanggal' => 'datetime',
    ];  

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id', 'penjualan_id');
    }

    public function totalPenjualan()
    {
        return $this->detailPenjualan->sum(function ($detail) {
            return $detail->harga * $detail->jumlah;
        });
    }
}