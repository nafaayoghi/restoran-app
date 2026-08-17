@extends('layouts.app')

@section('title', 'Tambah Pelanggan Baru')

@section('content')
<div class="card shadow-sm p-4 bg-white col-md-6 mx-auto">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0 text-dark">Tambah Pelanggan</h3>
        <a href="/pelanggan" class="btn btn-secondary">Kembali</a>
    </div>

    <form action="/pelanggan/store" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Pelanggan</label>
            <input type="text" name="NAMA_PELANGGAN" class="form-control" placeholder="Contoh: Kimberly Raghda" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Nomor Telepon</label>
            <input type="text" name="NOMOR_TELEPON" class="form-control" placeholder="Contoh: 08123456789" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-3 py-2 fw-bold shadow-sm">Simpan Pelanggan</button>
    </form>
</div>
@endsection