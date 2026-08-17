<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    protected $table = 'MEJA';
    protected $primaryKey = 'NOMOR_MEJA';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'NOMOR_MEJA',
        'KAPASITAS_MEJA'
    ];
}