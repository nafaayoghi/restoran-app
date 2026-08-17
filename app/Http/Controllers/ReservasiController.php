<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Pelanggan;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'semua');
        $now = Carbon::now('Asia/Jakarta');

        // 1. Batalkan otomatis yang lewat waktu
        $this->autoCancelLateReservations($now);

        // 2. Sinkronisasi blacklist otomatis
        $this->syncBlacklistStatus();

        $query = Reservasi::with(['pelanggan', 'meja']);

        if ($filter == 'terdekat') {
            $query->where('TANGGAL_RESERVASI', '>=', $now->toDateString())
                  ->where('STATUS_RESERVASI', 'Confirmed')
                  ->orderBy('TANGGAL_RESERVASI', 'asc')
                  ->orderBy('WAKTU_RESERVASI', 'asc');
            $reservasis = $query->get();
        } elseif ($filter == 'batal') {
            $query->where('STATUS_RESERVASI', 'Batal')
                  ->orderBy('TANGGAL_RESERVASI', 'desc')
                  ->orderBy('WAKTU_RESERVASI', 'desc');
            $reservasis = $query->get();
        } elseif ($filter == 'blacklist') {
            // Menampilkan riwayat pelanggan blacklist & hanya 1x per pelanggan
            $reservasis = $query->whereHas('pelanggan', function($q) {
                $q->where('IS_BLACKLIST', 1);
            })
            ->orderBy('TANGGAL_RESERVASI', 'desc')
            ->orderBy('WAKTU_RESERVASI', 'desc')
            ->get()
            ->unique('ID_PELANGGAN');
        } else {
            $query->orderBy('TANGGAL_RESERVASI', 'desc')->orderBy('WAKTU_RESERVASI', 'desc');
            $reservasis = $query->get();
        }

        return view('reservasi.index', compact('reservasis', 'filter'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::all();
        $meja = Meja::all();
        $menus = Menu::all();
        return view('reservasi.create', compact('pelanggan', 'meja', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_PELANGGAN' => 'required',
            'NOMOR_MEJA' => 'required',
            'TANGGAL_RESERVASI' => 'required|date',
            'WAKTU_RESERVASI' => 'required',
            'JUMLAH_ORANG' => 'required|numeric|min:1',
            'STATUS_RESERVASI' => 'required',
        ]);

        $pelanggan = Pelanggan::findOrFail($request->ID_PELANGGAN);
        $meja = Meja::findOrFail($request->NOMOR_MEJA);

        if ($pelanggan->IS_BLACKLIST) {
            return back()->withInput()->with('error', 'Gagal! Pelanggan ' . $pelanggan->NAMA_PELANGGAN . ' sedang dalam DAFTAR HITAM (Blacklist).');
        }

        if ($request->JUMLAH_ORANG > $meja->KAPASITAS_MEJA) {
            return back()->withInput()->with('error', "Gagal! Jumlah orang ({$request->JUMLAH_ORANG} orang) melebihi kapasitas Meja {$meja->NOMOR_MEJA} (Maksimal {$meja->KAPASITAS_MEJA} orang).");
        }

        $waktu = Carbon::createFromFormat('H:i', substr($request->WAKTU_RESERVASI, 0, 5));
        $jamBuka = Carbon::createFromFormat('H:i', '09:00');
        $jamTutup = Carbon::createFromFormat('H:i', '22:00');

        if ($waktu->lt($jamBuka) || $waktu->gt($jamTutup)) {
            return back()->withInput()->with('error', 'Jam reservasi harus dalam jam operasional restoran (09:00 - 22:00 WIB).');
        }

        $existing = Reservasi::where('ID_PELANGGAN', $request->ID_PELANGGAN)
            ->where('TANGGAL_RESERVASI', $request->TANGGAL_RESERVASI)
            ->where('STATUS_RESERVASI', '!=', 'Batal')
            ->first();

        if ($existing) {
            return back()->withInput()->with('error', 'Pelanggan ini sudah memiliki jadwal reservasi aktif di tanggal ' . $request->TANGGAL_RESERVASI . ' (Maks 1x sehari).');
        }

        $mejaTerpakai = Reservasi::where('NOMOR_MEJA', $request->NOMOR_MEJA)
            ->where('TANGGAL_RESERVASI', $request->TANGGAL_RESERVASI)
            ->where('WAKTU_RESERVASI', $request->WAKTU_RESERVASI)
            ->where('STATUS_RESERVASI', '!=', 'Batal')
            ->first();

        if ($mejaTerpakai) {
            return back()->withInput()->with('error', 'Meja ' . $request->NOMOR_MEJA . ' sudah direservasi pada waktu tersebut.');
        }

        $reservasi = Reservasi::create([
            'ID_PELANGGAN' => $request->ID_PELANGGAN,
            'NOMOR_MEJA' => $request->NOMOR_MEJA,
            'TANGGAL_RESERVASI' => $request->TANGGAL_RESERVASI,
            'WAKTU_RESERVASI' => $request->WAKTU_RESERVASI,
            'JUMLAH_ORANG' => $request->JUMLAH_ORANG,
            'STATUS_RESERVASI' => $request->STATUS_RESERVASI,
            'CATATAN_PREFERENSI' => $request->CATATAN_PREFERENSI,
            'TOTAL_BARANG' => 0.00,
        ]);

        $totalBelanja = 0;
        if ($request->has('ID_MENU') && is_array($request->ID_MENU)) {
            foreach ($request->ID_MENU as $index => $idMenu) {
                $qty = $request->JUMLAH_MENU[$index] ?? 0;
                if (!empty($idMenu) && $qty > 0) {
                    $menu = Menu::find($idMenu);
                    if ($menu) {
                        $subtotal = $menu->HARGA_MENU * $qty;
                        DetailPesanan::create([
                            'ID_RESERVASI' => $reservasi->ID_RESERVASI,
                            'ID_MENU' => $idMenu,
                            'JUMLAH' => $qty,
                            'HARGA_SATUAN' => $menu->HARGA_MENU,
                            'SUBTOTAL' => $subtotal,
                        ]);
                        $totalBelanja += $subtotal;
                    }
                }
            }
            $reservasi->update(['TOTAL_BARANG' => $totalBelanja]);
        }

        return redirect('/reservasi')->with('success', 'Reservasi berhasil disimpan!');
    }

    public function edit($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $pelanggan = Pelanggan::all();
        $meja = Meja::all();
        return view('reservasi.edit', compact('reservasi', 'pelanggan', 'meja'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ID_PELANGGAN' => 'required',
            'NOMOR_MEJA' => 'required',
            'TANGGAL_RESERVASI' => 'required|date',
            'WAKTU_RESERVASI' => 'required',
            'JUMLAH_ORANG' => 'required|numeric|min:1',
            'STATUS_RESERVASI' => 'required',
        ]);

        $meja = Meja::findOrFail($request->NOMOR_MEJA);

        if ($request->JUMLAH_ORANG > $meja->KAPASITAS_MEJA) {
            return back()->withInput()->with('error', "Gagal! Jumlah orang ({$request->JUMLAH_ORANG} orang) melebihi kapasitas Meja {$meja->NOMOR_MEJA} (Maksimal {$meja->KAPASITAS_MEJA} orang).");
        }

        $waktu = Carbon::createFromFormat('H:i', substr($request->WAKTU_RESERVASI, 0, 5));
        if ($waktu->lt(Carbon::createFromFormat('H:i', '09:00')) || $waktu->gt(Carbon::createFromFormat('H:i', '22:00'))) {
            return back()->withInput()->with('error', 'Jam reservasi harus antara pukul 09:00 sampai 22:00 WIB.');
        }

        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update([
            'ID_PELANGGAN' => $request->ID_PELANGGAN,
            'NOMOR_MEJA' => $request->NOMOR_MEJA,
            'TANGGAL_RESERVASI' => $request->TANGGAL_RESERVASI,
            'WAKTU_RESERVASI' => $request->WAKTU_RESERVASI,
            'JUMLAH_ORANG' => $request->JUMLAH_ORANG,
            'STATUS_RESERVASI' => $request->STATUS_RESERVASI,
            'CATATAN_PREFERENSI' => $request->CATATAN_PREFERENSI,
        ]);

        $this->syncBlacklistStatus();

        return redirect('/reservasi')->with('success', 'Data reservasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        DetailPesanan::where('ID_RESERVASI', $id)->delete();
        $reservasi->delete();
        return redirect('/reservasi')->with('success', 'Data reservasi berhasil dihapus!');
    }

    private function autoCancelLateReservations($now)
    {
        $today = $now->toDateString();
        $currentTime = $now->format('H:i:s');

        Reservasi::where('STATUS_RESERVASI', 'Confirmed')
            ->where(function($query) use ($today, $currentTime) {
                $query->where('TANGGAL_RESERVASI', '<', $today)
                      ->orWhere(function($sub) use ($today, $currentTime) {
                          $sub->where('TANGGAL_RESERVASI', '=', $today)
                              ->where('WAKTU_RESERVASI', '<', $currentTime);
                      });
            })
            ->update(['STATUS_RESERVASI' => 'Batal']);
    }

    private function syncBlacklistStatus()
    {
        $oneMonthAgo = Carbon::now('Asia/Jakarta')->subDays(30)->toDateString();

        $pelangganBandel = Reservasi::where('STATUS_RESERVASI', 'Batal')
            ->where('TANGGAL_RESERVASI', '>=', $oneMonthAgo)
            ->groupBy('ID_PELANGGAN')
            ->havingRaw('COUNT(ID_RESERVASI) >= 3')
            ->pluck('ID_PELANGGAN');

        if ($pelangganBandel->isNotEmpty()) {
            Pelanggan::whereIn('ID_PELANGGAN', $pelangganBandel)->update(['IS_BLACKLIST' => 1]);
        }
    }
}