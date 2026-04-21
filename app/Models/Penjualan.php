<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MUser;
use App\Models\PenjualanDetail;

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

    public function user()
    {
        return $this->belongsTo(MUser::class, 'user_id', 'user_id');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id', 'penjualan_id');
    }
}