@extends('layouts.app')

@section('title', 'Daftar Reservasi')

@section('content')
<div class="card shadow-sm p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="m-0 fw-bold text-dark">Daftar Reservasi Pelanggan</h3>
            <small class="text-muted">Jam Operasional: 09:00 - 22:00 WIB | Reservasi lewat waktu otomatis dibatalkan sistem</small>
        </div>
        <a href="/reservasi/create" class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Reservasi</a>
    </div>

    <!-- FILTER BAR -->
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="/reservasi?filter=semua" class="btn btn-sm {{ $filter == 'semua' ? 'btn-dark' : 'btn-outline-dark' }}">Semua</a>
        <a href="/reservasi?filter=terdekat" class="btn btn-sm {{ $filter == 'terdekat' ? 'btn-primary' : 'btn-outline-primary' }}">⏱️ Waktu Terdekat</a>
        <a href="/reservasi?filter=batal" class="btn btn-sm {{ $filter == 'batal' ? 'btn-warning' : 'btn-outline-warning' }}">❌ Dibatalkan / Tidak Hadir</a>
        <a href="/reservasi?filter=blacklist" class="btn btn-sm {{ $filter == 'blacklist' ? 'btn-secondary' : 'btn-outline-secondary' }}">🚫 Pelanggan Blacklist</a>
    </div>

    <div class="table-responsive">
        <table id="tabelReservasi" class="table table-hover table-bordered align-middle w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th>Nama Pelanggan</th>
                    <th>Meja</th>
                    <th>Tanggal & Waktu</th>
                    <th>Jumlah Orang</th>
                    <th>Preferensi / Catatan</th>
                    <th>Total Tagihan</th>
                    <th>Status</th>
                    <th class="text-center" style="width: 170px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservasis as $item)
                <tr>
                    <td class="fw-bold">#{{ $item->ID_RESERVASI }}</td>
                    <td>
                        <span class="fw-semibold">{{ $item->pelanggan->NAMA_PELANGGAN ?? '-' }}</span>
                        @if($item->pelanggan && $item->pelanggan->IS_BLACKLIST)
                            <span class="badge bg-danger ms-1">Blacklist</span>
                        @endif
                    </td>
                    <td><span class="badge bg-primary fs-6">{{ $item->NOMOR_MEJA }}</span></td>
                    <td>{{ $item->TANGGAL_RESERVASI }} {{ $item->WAKTU_RESERVASI }}</td>
                    <td>{{ $item->JUMLAH_ORANG }} Orang</td>
                    <td>
                        @if(!empty($item->CATATAN_PREFERENSI))
                            <span class="text-secondary small"><i class="bi bi-chat-left-text me-1 text-primary"></i>{{ $item->CATATAN_PREFERENSI }}</span>
                        @else
                            <span class="text-muted small fst-italic">- Tidak ada -</span>
                        @endif
                    </td>
                    <td class="fw-bold text-success">Rp {{ number_format($item->TOTAL_BARANG ?? 0, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge bg-{{ $item->STATUS_RESERVASI == 'Selesai' ? 'success' : ($item->STATUS_RESERVASI == 'Confirmed' ? 'primary' : 'danger') }}">
                            {{ $item->STATUS_RESERVASI }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="/reservasi/{{ $item->ID_RESERVASI }}/detail" class="btn btn-sm btn-info text-white" title="Kasir & Pesanan"><i class="bi bi-receipt"></i></a>
                        <a href="/reservasi/{{ $item->ID_RESERVASI }}/edit" class="btn btn-sm btn-warning text-white" title="Edit"><i class="bi bi-pencil-square"></i></a>
                        <form action="/reservasi/{{ $item->ID_RESERVASI }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-delete" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#tabelReservasi').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data reservasi...",
                lengthMenu: "Tampilkan _MENU_ baris",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ reservasi",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                },
                emptyTable: "Tidak ada data reservasi ditemukan"
            },
            dom: '<"d-flex flex-wrap justify-content-between align-items-center mb-3"Bf>rt<"d-flex flex-wrap justify-content-between align-items-center mt-3"lip>',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="bi bi-file-earmark-excel me-1"></i> Excel',
                    className: 'btn btn-sm btn-success',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="bi bi-file-earmark-pdf me-1"></i> PDF',
                    className: 'btn btn-sm btn-danger',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                },
                {
                    extend: 'print',
                    text: '<i class="bi bi-printer me-1"></i> Print',
                    className: 'btn btn-sm btn-secondary',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
                }
            ]
        });
    });
</script>
@endsection