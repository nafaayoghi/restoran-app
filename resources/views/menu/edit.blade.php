@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="bg-white p-4 rounded shadow-sm col-md-6 mx-auto">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Menu</h2>
        <a href="/menu" class="btn btn-secondary">Kembali</a>
    </div>

    <form action="/menu/{{ $menu->ID_MENU }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Menu</label>
            <input type="text" name="NAMA_MENU" class="form-control" value="{{ $menu->NAMA_MENU }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="KATEGORI_MENU" class="form-select" required>
                <option value="Makanan Utama" {{ $menu->KATEGORI_MENU == 'Makanan Utama' ? 'selected' : '' }}>Makanan Utama</option>
                <option value="Minuman" {{ $menu->KATEGORI_MENU == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                <option value="Cemilan" {{ $menu->KATEGORI_MENU == 'Cemilan' ? 'selected' : '' }}>Cemilan</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga (Rp)</label>
            <input type="number" name="HARGA_MENU" class="form-control" value="{{ $menu->HARGA_MENU }}" required>
        </div>

        <button type="submit" class="btn btn-warning text-white w-100 mt-3 fw-bold">Update Menu</button>
    </form>
</div>
@endsection