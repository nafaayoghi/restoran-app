@extends('layouts.app')

@section('title', 'Dashboard Utama Restoran')

@section('content')
<div class="row g-4 mb-4">
    <!-- Total Reservasi -->
    <div class="col-md-3">
        <div class="card bg-primary text-white p-3 shadow-sm rounded-3 border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-1 text-white-50">Total Reservasi</h6>
                    <h3 class="fw-bold mb-0">{{ $totalReservasi }}</h3>
                </div>
                <div class="fs-1"><i class="bi bi-calendar-check"></i></div>
            </div>
        </div>
    </div>

    <!-- Total Pelanggan -->
    <div class="col-md-3">
        <div class="card bg-success text-white p-3 shadow-sm rounded-3 border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-1 text-white-50">Pelanggan Terdaftar</h6>
                    <h3 class="fw-bold mb-0">{{ $totalPelanggan }}</h3>
                </div>
                <div class="fs-1"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>

    <!-- Total Blacklist -->
    <div class="col-md-3">
        <div class="card bg-danger text-white p-3 shadow-sm rounded-3 border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-1 text-white-50">Pelanggan Blacklist</h6>
                    <h3 class="fw-bold mb-0">{{ $totalBlacklist }}</h3>
                </div>
                <div class="fs-1"><i class="bi bi-shield-x"></i></div>
            </div>
        </div>
    </div>

    <!-- Total Pendapatan -->
    <div class="col-md-3">
        <div class="card bg-dark text-white p-3 shadow-sm rounded-3 border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-1 text-white-50">Total Pendapatan</h6>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
                <div class="fs-1"><i class="bi bi-cash-stack"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- TOP PELANGGAN -->
    <div class="col-md-6">
        <div class="bg-white p-4 rounded shadow-sm h-100">
            <h5 class="fw-bold mb-3">🏆 Top Pelanggan Teraktif</h5>
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Pelanggan</th>
                        <th class="text-center">Total Reservasi</th>
                        <th>Total Belanja</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topPelanggan as $p)
                    <tr>
                        <td>
                            <strong>{{ $p->NAMA_PELANGGAN }}</strong>
                            @if($p->IS_BLACKLIST)
                                <span class="badge bg-danger">Blacklist</span>
                            @endif
                        </td>
                        <td class="text-center"><span class="badge bg-primary rounded-pill">{{ $p->reservasi_count }}x</span></td>
                        <td class="text-success fw-bold">Rp {{ number_format($p->reservasi_sum_total_barang ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">Belum ada aktivitas pelanggan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- RESERVASI HARI INI -->
    <div class="col-md-6">
        <div class="bg-white p-4 rounded shadow-sm h-100">
            <h5 class="fw-bold mb-3">📅 Reservasi Hari Ini</h5>
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Waktu</th>
                        <th>Pelanggan</th>
                        <th>Meja</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservasiHariIni as $r)
                    <tr>
                        <td><strong>{{ $r->WAKTU_RESERVASI }}</strong></td>
                        <td>{{ $r->pelanggan->NAMA_PELANGGAN ?? '-' }}</td>
                        <td><span class="badge bg-secondary">{{ $r->NOMOR_MEJA }}</span></td>
                        <td>
                            <span class="badge bg-{{ $r->STATUS_RESERVASI == 'Selesai' ? 'success' : ($r->STATUS_RESERVASI == 'Confirmed' ? 'primary' : 'danger') }}">
                                {{ $r->STATUS_RESERVASI }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Tidak ada jadwal reservasi untuk hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection