<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'RESERVASI';
    protected $primaryKey = 'ID_RESERVASI';
    public $timestamps = false;

    protected $fillable = [
        'ID_PELANGGAN',
        'NOMOR_MEJA',
        'TANGGAL_RESERVASI',
        'WAKTU_RESERVASI',
        'JUMLAH_ORANG',
        'STATUS_RESERVASI',
        'TOTAL_BARANG',
        'CATATAN_PREFERENSI'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'ID_PELANGGAN', 'ID_PELANGGAN');
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class, 'NOMOR_MEJA', 'NOMOR_MEJA');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'ID_RESERVASI', 'ID_RESERVASI');
    }
}