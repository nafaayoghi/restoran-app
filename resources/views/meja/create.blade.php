@extends('layouts.app')

@section('title', 'Tambah Meja Baru')

@section('content')
<div class="bg-white p-4 rounded shadow-sm col-md-6 mx-auto">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Tambah Meja Baru</h2>
        <a href="/meja" class="btn btn-secondary">Kembali</a>
    </div>

    <form action="/meja/store" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nomor Meja</label>
            <input type="text" name="NOMOR_MEJA" class="form-control" placeholder="Contoh: M05 atau VIP02" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kapasitas (Orang)</label>
            <input type="number" name="KAPASITAS_MEJA" class="form-control" min="1" placeholder="Contoh: 4" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-3">Simpan Meja</button>
    </form>
</div>
@endsection