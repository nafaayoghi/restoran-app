@extends('layouts.app')

@section('title', 'Daftar Pelanggan')

@section('content')
<div class="card shadow-sm p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0 fw-bold text-dark">Daftar Pelanggan Restoran</h3>
        <a href="/pelanggan/create" class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Pelanggan</a>
    </div>

    <div class="table-responsive">
        <table id="tabelPelanggan" class="table table-hover table-bordered align-middle w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th>Nama Pelanggan</th>
                    <th>Nomor Telepon</th>
                    <th>Total Reservasi</th>
                    <th>Status Akun</th>
                    <th class="text-center" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelanggan as $item)
                <tr>
                    <td class="fw-bold">#{{ $item->ID_PELANGGAN }}</td>
                    <td class="fw-semibold">{{ $item->NAMA_PELANGGAN }}</td>
                    <td>{{ $item->NOMOR_TELEPON }}</td>
                    <td><span class="badge bg-secondary">{{ $item->total_reservasi ?? 0 }}x Reservasi</span></td>
                    <td>
                        @if($item->IS_BLACKLIST)
                            <span class="badge bg-danger"><i class="bi bi-shield-x me-1"></i> Blacklist</span>
                        @else
                            <span class="badge bg-success"><i class="bi bi-shield-check me-1"></i> Normal</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="/pelanggan/{{ $item->ID_PELANGGAN }}/edit" class="btn btn-sm btn-warning text-white"><i class="bi bi-pencil-square"></i> Edit</a>
                        <form action="/pelanggan/{{ $item->ID_PELANGGAN }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="bi bi-trash"></i></button>
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
        $('#tabelPelanggan').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari pelanggan...",
                lengthMenu: "Tampilkan _MENU_ baris",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pelanggan",
                paginate: { next: "Berikutnya", previous: "Sebelumnya" }
            },
            dom: '<"d-flex flex-wrap justify-content-between align-items-center mb-3"Bf>rt<"d-flex flex-wrap justify-content-between align-items-center mt-3"lip>',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="bi bi-file-earmark-excel me-1"></i> Excel',
                    className: 'btn btn-sm btn-success',
                    exportOptions: { columns: [0, 1, 2, 3, 4] }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="bi bi-file-earmark-pdf me-1"></i> PDF',
                    className: 'btn btn-sm btn-danger',
                    exportOptions: { columns: [0, 1, 2, 3, 4] }
                }
            ]
        });
    });
</script>
@endsection