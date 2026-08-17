<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Menampilkan daftar seluruh pelanggan beserta jumlah reservasinya.
     */
    public function index()
    {
        $pelanggan = Pelanggan::withCount('reservasi as total_reservasi')->get();
        return view('pelanggan.index', compact('pelanggan'));
    }

    /**
     * Menampilkan form tambah pelanggan baru.
     */
    public function create()
    {
        return view('pelanggan.create');
    }

    /**
     * Menyimpan data pelanggan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'NAMA_PELANGGAN' => 'required|string|max:100',
            'NOMOR_TELEPON'  => 'required|string|max:20',
        ]);

        Pelanggan::create([
            'NAMA_PELANGGAN' => $request->NAMA_PELANGGAN,
            'NOMOR_TELEPON'  => $request->NOMOR_TELEPON,
            'IS_BLACKLIST'   => 0,
        ]);

        return redirect('/pelanggan')->with('success', 'Data pelanggan baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit data pelanggan.
     */
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Memperbarui data pelanggan (nama, nomor telepon, status blacklist).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'NAMA_PELANGGAN' => 'required|string|max:100',
            'NOMOR_TELEPON'  => 'required|string|max:20',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        
        $pelanggan->update([
            'NAMA_PELANGGAN' => $request->NAMA_PELANGGAN,
            'NOMOR_TELEPON'  => $request->NOMOR_TELEPON,
            'IS_BLACKLIST'   => $request->has('IS_BLACKLIST') ? 1 : 0,
        ]);

        return redirect('/pelanggan')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    /**
     * Menghapus data pelanggan dengan validasi integritas data referensi.
     */
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // Cek apakah pelanggan masih memiliki riwayat di tabel RESERVASI
        $adaReservasi = Reservasi::where('ID_PELANGGAN', $id)->exists();

        if ($adaReservasi) {
            return redirect('/pelanggan')->with(
                'error', 
                'Gagal menghapus! Pelanggan ' . $pelanggan->NAMA_PELANGGAN . ' masih memiliki riwayat reservasi/transaksi di sistem.'
            );
        }

        $pelanggan->delete();

        return redirect('/pelanggan')->with('success', 'Data pelanggan berhasil dihapus!');
    }
}