<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Menu;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;

class DetailPesananController extends Controller
{
    // Menampilkan halaman detail pesanan untuk satu reservasi
    public function show($id)
    {
        $reservasi = Reservasi::with(['pelanggan', 'meja', 'detailPesanan.menu'])->findOrFail($id);
        $menus = Menu::all();

        return view('detail_pesanan.show', compact('reservasi', 'menus'));
    }

    // Menambah item menu ke dalam pesanan (Otomatis gabung jika menu sudah ada)
    public function store(Request $request, $id)
    {
        $request->validate([
            'ID_MENU' => 'required',
            'JUMLAH_PESANAN' => 'required|numeric|min:1',
        ]);

        $menu = Menu::findOrFail($request->ID_MENU);
        $hargaSatuan = $menu->HARGA_MENU;

        // Cek apakah menu sudah pernah dipesan di reservasi ini
        $existingDetail = DetailPesanan::where('ID_RESERVASI', $id)
            ->where('ID_MENU', $request->ID_MENU)
            ->first();

        if ($existingDetail) {
            // Jika sudah ada, tambahkan jumlahnya (Qty) dan hitung ulang subtotal
            $jumlahBaru = $existingDetail->JUMLAH + $request->JUMLAH_PESANAN;
            $subtotalBaru = $hargaSatuan * $jumlahBaru;

            DetailPesanan::where('ID_RESERVASI', $id)
                ->where('ID_MENU', $request->ID_MENU)
                ->update([
                    'JUMLAH' => $jumlahBaru,
                    'SUBTOTAL' => $subtotalBaru,
                ]);
        } else {
            // Jika belum ada, buat baris pesanan baru
            $subtotal = $hargaSatuan * $request->JUMLAH_PESANAN;
            DetailPesanan::create([
                'ID_RESERVASI' => $id,
                'ID_MENU' => $request->ID_MENU,
                'JUMLAH' => $request->JUMLAH_PESANAN,
                'HARGA_SATUAN' => $hargaSatuan,
                'SUBTOTAL' => $subtotal,
            ]);
        }

        // Hitung ulang TOTAL_BARANG di tabel RESERVASI
        $totalBarang = DetailPesanan::where('ID_RESERVASI', $id)->sum('SUBTOTAL');
        Reservasi::where('ID_RESERVASI', $id)->update(['TOTAL_BARANG' => $totalBarang]);

        return redirect('/reservasi/' . $id . '/detail')->with('success', 'Pesanan menu berhasil diperbarui!');
    }

    // Menghapus item dari pesanan
    public function destroy($id_reservasi, $id_menu)
    {
        DetailPesanan::where('ID_RESERVASI', $id_reservasi)
            ->where('ID_MENU', $id_menu)
            ->delete();

        // Hitung ulang TOTAL_BARANG di tabel RESERVASI
        $totalBarang = DetailPesanan::where('ID_RESERVASI', $id_reservasi)->sum('SUBTOTAL');
        Reservasi::where('ID_RESERVASI', $id_reservasi)->update(['TOTAL_BARANG' => $totalBarang]);

        return redirect('/reservasi/' . $id_reservasi . '/detail')->with('success', 'Item pesanan berhasil dihapus!');
    }
}