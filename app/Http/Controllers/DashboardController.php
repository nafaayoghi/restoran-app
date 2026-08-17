<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Meja;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now('Asia/Jakarta');
        $today = $now->toDateString();

        $totalReservasi = Reservasi::count();
        $totalPelanggan = Pelanggan::count();
        $totalBlacklist = Pelanggan::where('IS_BLACKLIST', 1)->count();
        $totalPendapatan = Reservasi::sum('TOTAL_BARANG');

        // Top 5 Pelanggan Paling Sering Reservasi / Memesan
        $topPelanggan = Pelanggan::withCount('reservasi')
            ->withSum('reservasi', 'TOTAL_BARANG')
            ->orderBy('reservasi_count', 'desc')
            ->take(5)
            ->get();

        // Reservasi Hari Ini
        $reservasiHariIni = Reservasi::with(['pelanggan', 'meja'])
            ->where('TANGGAL_RESERVASI', $today)
            ->orderBy('WAKTU_RESERVASI', 'asc')
            ->get();

        return view('dashboard', compact(
            'totalReservasi',
            'totalPelanggan',
            'totalBlacklist',
            'totalPendapatan',
            'topPelanggan',
            'reservasiHariIni'
        ));
    }
}