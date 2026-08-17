@extends('layouts.app')

@section('title', 'Daftar Menu')

@section('content')
<div class="card shadow-sm p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0 fw-bold text-dark">Daftar Menu Restoran</h3>
        <a href="/menu/create" class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Menu</a>
    </div>

    <div class="table-responsive">
        <table id="tabelMenu" class="table table-hover table-bordered align-middle w-100">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga Satuan</th>
                    <th class="text-center" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $item)
                <tr>
                    <td class="fw-bold">#{{ $item->ID_MENU }}</td>
                    <td class="fw-semibold">{{ $item->NAMA_MENU }}</td>
                    <td><span class="badge bg-secondary">{{ $item->KATEGORI_MENU }}</span></td>
                    <td class="fw-bold text-primary">Rp {{ number_format($item->HARGA_MENU, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <a href="/menu/{{ $item->ID_MENU }}/edit" class="btn btn-sm btn-warning text-white"><i class="bi bi-pencil-square"></i> Edit</a>
                        <form action="/menu/{{ $item->ID_MENU }}" method="POST" class="d-inline">
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
        $('#tabelMenu').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari nama menu...",
                lengthMenu: "Tampilkan _MENU_ baris",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ menu",
                paginate: { next: "Berikutnya", previous: "Sebelumnya" }
            },
            dom: '<"d-flex flex-wrap justify-content-between align-items-center mb-3"Bf>rt<"d-flex flex-wrap justify-content-between align-items-center mt-3"lip>',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="bi bi-file-earmark-excel me-1"></i> Excel',
                    className: 'btn btn-sm btn-success',
                    exportOptions: { columns: [0, 1, 2, 3] }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="bi bi-file-earmark-pdf me-1"></i> PDF',
                    className: 'btn btn-sm btn-danger',
                    exportOptions: { columns: [0, 1, 2, 3] }
                }
            ]
        });
    });
</script>
@endsection