<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'MENU';
    protected $primaryKey = 'ID_MENU';
    public $timestamps = false;

    protected $fillable = [
        'NAMA_MENU',
        'HARGA_MENU',
        'KATEGORI_MENU'
    ];
}