@extends('layouts.app')

@section('title', 'Tambah Menu Baru')

@section('content')
<div class="bg-white p-4 rounded shadow-sm col-md-6 mx-auto">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Tambah Menu Baru</h2>
        <a href="/menu" class="btn btn-secondary">Kembali</a>
    </div>

    <form action="/menu/store" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Menu</label>
            <input type="text" name="NAMA_MENU" class="form-control" placeholder="Contoh: Es Jeruk Segar" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="KATEGORI_MENU" class="form-select" required>
                <option value="Makanan Utama">Makanan Utama</option>
                <option value="Minuman">Minuman</option>
                <option value="Cemilan">Cemilan</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga (Rp)</label>
            <input type="number" name="HARGA_MENU" class="form-control" placeholder="Contoh: 15000" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-3">Simpan Menu</button>
    </form>
</div>
@endsection