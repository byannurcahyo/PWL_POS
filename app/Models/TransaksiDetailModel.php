<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetailModel extends Model
{
    use HasFactory;

    protected $table = 't_penjualan_detail';
    protected $primaryKey = 'detail_id';

    protected $fillable = [
        'detail_id',
        'penjualan_id',
        'barang_id',
        'jumlah',
        'harga'
    ];

    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id', 'barang_id');
    }

    public function penjualan()
    {
        return $this->belongsTo(TransaksiModel::class, 'penjualan_id', 'penjualan_id');
    }
}