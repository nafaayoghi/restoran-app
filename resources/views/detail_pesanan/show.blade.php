@extends('layouts.app')

@section('title', 'Detail Pesanan Reservasi')

@section('content')
<!-- CSS khusus untuk mode cetak/print struk -->
<style>
    @media print {
        .sidebar, .navbar, .btn, form, .no-print {
            display: none !important;
        }
        .content-wrapper {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        body {
            background-color: #fff !important;
        }
        .shadow-sm {
            box-shadow: none !important;
        }
    }
</style>

<div class="row">
    <!-- INFO RESERVASI & FORM TAMBAH ITEM -->
    <div class="col-md-5 mb-4">
        <div class="bg-white p-4 rounded shadow-sm mb-4">
            <h4 class="fw-bold mb-3">Info Reservasi #{{ $reservasi->ID_RESERVASI }}</h4>
            <hr>
            <p class="mb-1"><strong>Pelanggan:</strong> {{ $reservasi->pelanggan->NAMA_PELANGGAN ?? '-' }}</p>
            <p class="mb-1"><strong>Nomor Meja:</strong> <span class="badge bg-primary">{{ $reservasi->NOMOR_MEJA }}</span></p>
            <p class="mb-1"><strong>Tanggal/Waktu:</strong> {{ $reservasi->TANGGAL_RESERVASI }} {{ $reservasi->WAKTU_RESERVASI }}</p>
            <p class="mb-3"><strong>Status:</strong> <span class="badge bg-success">{{ $reservasi->STATUS_RESERVASI }}</span></p>
            
            <a href="/reservasi" class="btn btn-outline-secondary btn-sm w-100 no-print">&laquo; Kembali ke Daftar Reservasi</a>
            <button onclick="window.print()" class="btn btn-outline-dark btn-sm w-100 mt-2 no-print">
                🖨️ Cetak Struk Pembayaran
            </button>
        </div>

        <div class="bg-white p-4 rounded shadow-sm no-print">
            <h5 class="fw-bold mb-3">+ Tambah Pesanan Menu</h5>
            
            <form action="/reservasi/{{ $reservasi->ID_RESERVASI }}/detail/store" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pilih Menu</label>
                    <select name="ID_MENU" class="form-select" required>
                        <option value="">-- Pilih Menu --</option>
                        @foreach($menus as $m)
                            <option value="{{ $m->ID_MENU }}">{{ $m->NAMA_MENU }} - Rp {{ number_format($m->HARGA_MENU, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah (Qty)</label>
                    <input type="number" name="JUMLAH_PESANAN" class="form-control" value="1" min="1" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Tambahkan Pesanan</button>
            </form>
        </div>
    </div>

    <!-- TABEL DAFTAR PESANAN MENU -->
    <div class="col-md-7">
        <div class="bg-white p-4 rounded shadow-sm">
            <h4 class="fw-bold mb-3">Item Pesanan Restoran</h4>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Menu</th>
                        <th>Harga Satuan</th>
                        <th class="text-center">Qty</th>
                        <th>Subtotal</th>
                        <th class="text-center no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservasi->detailPesanan as $detail)
                    <tr>
                        <td>{{ $detail->menu->NAMA_MENU ?? '-' }}</td>
                        <td>Rp {{ number_format($detail->HARGA_SATUAN ?? 0, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $detail->JUMLAH }}</td>
                        <td class="fw-bold">Rp {{ number_format($detail->SUBTOTAL ?? 0, 0, ',', '.') }}</td>
                        <td class="text-center no-print">
                            <form action="/reservasi/{{ $reservasi->ID_RESERVASI }}/detail/{{ $detail->ID_MENU }}" method="POST" onsubmit="return confirm('Hapus menu ini dari pesanan?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada menu yang dipesan. Pilih menu di samping untuk menambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-primary fs-5 fw-bold">
                        <td colspan="3" class="text-end">Total Tagihan:</td>
                        <td colspan="2" class="text-primary">Rp {{ number_format($reservasi->TOTAL_BARANG ?? 0, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection