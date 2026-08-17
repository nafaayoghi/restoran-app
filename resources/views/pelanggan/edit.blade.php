@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="card shadow-sm p-4 bg-white col-md-6 mx-auto">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0 text-dark">Edit Pelanggan</h3>
        <a href="/pelanggan" class="btn btn-secondary">Kembali</a>
    </div>

    <form action="/pelanggan/{{ $pelanggan->ID_PELANGGAN }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Pelanggan</label>
            <input type="text" name="NAMA_PELANGGAN" class="form-control" value="{{ $pelanggan->NAMA_PELANGGAN }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Nomor Telepon</label>
            <input type="text" name="NOMOR_TELEPON" class="form-control" value="{{ $pelanggan->NOMOR_TELEPON }}" required>
        </div>

        <!-- TOGGLE BLACKLIST ADMIN -->
        <div class="form-check form-switch mb-3 p-3 bg-light rounded border">
            <input class="form-check-input ms-0 me-2" type="checkbox" name="IS_BLACKLIST" id="blacklistSwitch" {{ $pelanggan->IS_BLACKLIST ? 'checked' : '' }}>
            <label class="form-check-label fw-bold text-danger" for="blacklistSwitch">
                Masukkan ke Daftar Hitam (Blacklist)
            </label>
            <div class="form-text">Pelanggan yang diblacklist dilarang melakukan reservasi baru.</div>
        </div>

        <button type="submit" class="btn btn-warning text-white w-100 mt-3 py-2 fw-bold shadow-sm">Update Pelanggan</button>
    </form>
</div>
@endsection