<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'DETAIL_PESANAN';
    public $incrementing = false;
    public $timestamps = false;

    // Sesuaikan persis dengan kolom SSMS
    protected $fillable = [
        'ID_RESERVASI',
        'ID_MENU',
        'JUMLAH',
        'HARGA_SATUAN',
        'SUBTOTAL'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'ID_MENU', 'ID_MENU');
    }

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'ID_RESERVASI', 'ID_RESERVASI');
    }
}