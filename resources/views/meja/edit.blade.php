@extends('layouts.app')

@section('title', 'Edit Meja')

@section('content')
<div class="bg-white p-4 rounded shadow-sm col-md-6 mx-auto">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Meja ({{ $meja->NOMOR_MEJA }})</h2>
        <a href="/meja" class="btn btn-secondary">Kembali</a>
    </div>

    <form action="/meja/{{ $meja->NOMOR_MEJA }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nomor Meja</label>
            <input type="text" class="form-control" value="{{ $meja->NOMOR_MEJA }}" disabled>
            <small class="text-muted">Nomor meja tidak dapat diubah (Primary Key).</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Kapasitas (Orang)</label>
            <input type="number" name="KAPASITAS_MEJA" class="form-control" value="{{ $meja->KAPASITAS_MEJA }}" required>
        </div>

        <button type="submit" class="btn btn-warning text-white w-100 mt-3 fw-bold">Update Meja</button>
    </form>
</div>
@endsection