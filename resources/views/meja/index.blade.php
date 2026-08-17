@extends('layouts.app')

@section('title', 'Daftar Meja')

@section('content')
<div class="card shadow-sm p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0 fw-bold text-dark">Daftar Meja Restoran</h3>
        <a href="/meja/create" class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Meja</a>
    </div>

    <div class="table-responsive">
        <table id="tabelMeja" class="table table-hover table-bordered align-middle w-100">
            <thead class="table-light">
                <tr>
                    <th>Nomor Meja</th>
                    <th>Kapasitas Meja</th>
                    <th class="text-center" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($meja as $item)
                <tr>
                    <td><span class="badge bg-primary fs-6">{{ $item->NOMOR_MEJA }}</span></td>
                    <td class="fw-semibold">{{ $item->KAPASITAS_MEJA }} Orang</td>
                    <td class="text-center">
                        <a href="/meja/{{ $item->NOMOR_MEJA }}/edit" class="btn btn-sm btn-warning text-white"><i class="bi bi-pencil-square"></i> Edit</a>
                        <form action="/meja/{{ $item->NOMOR_MEJA }}" method="POST" class="d-inline">
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
        $('#tabelMeja').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari nomor meja...",
                lengthMenu: "Tampilkan _MENU_ baris",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ meja",
                paginate: { next: "Berikutnya", previous: "Sebelumnya" }
            }
        });
    });
</script>
@endsection