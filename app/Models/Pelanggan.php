<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'PELANGGAN';
    protected $primaryKey = 'ID_PELANGGAN';
    public $timestamps = false;

    protected $fillable = [
        'NAMA_PELANGGAN',
        'NOMOR_TELEPON',
        'PREFERENSI_KHUSUS',
        'IS_BLACKLIST'
    ];

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'ID_PELANGGAN', 'ID_PELANGGAN');
    }
}