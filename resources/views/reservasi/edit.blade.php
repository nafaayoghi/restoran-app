@extends('layouts.app')

@section('title', 'Edit Reservasi')

@section('content')
<div class="card shadow-sm p-4 bg-white col-md-8 mx-auto">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0 text-dark">Edit Reservasi #{{ $reservasi->ID_RESERVASI }}</h3>
        <a href="/reservasi" class="btn btn-secondary">Kembali</a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="/reservasi/{{ $reservasi->ID_RESERVASI }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Pelanggan</label>
            <select name="ID_PELANGGAN" class="form-select" required>
                @foreach($pelanggan as $p)
                    <option value="{{ $p->ID_PELANGGAN }}" {{ $reservasi->ID_PELANGGAN == $p->ID_PELANGGAN ? 'selected' : '' }}>
                        {{ $p->NAMA_PELANGGAN }} ({{ $p->NOMOR_TELEPON }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Nomor Meja</label>
            <select name="NOMOR_MEJA" class="form-select" required>
                @foreach($meja as $m)
                    <option value="{{ $m->NOMOR_MEJA }}" {{ $reservasi->NOMOR_MEJA == $m->NOMOR_MEJA ? 'selected' : '' }}>
                        Meja {{ $m->NOMOR_MEJA }} (Kapasitas: {{ $m->KAPASITAS_MEJA }} orang)
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Tanggal Reservasi</label>
                <input type="date" name="TANGGAL_RESERVASI" class="form-control" value="{{ $reservasi->TANGGAL_RESERVASI }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Waktu Reservasi (09:00 - 22:00)</label>
                <input type="time" name="WAKTU_RESERVASI" class="form-control" value="{{ $reservasi->WAKTU_RESERVASI }}" min="09:00" max="22:00" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Jumlah Orang</label>
                <input type="number" name="JUMLAH_ORANG" class="form-control" value="{{ $reservasi->JUMLAH_ORANG }}" min="1" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Status Reservasi</label>
                <select name="STATUS_RESERVASI" class="form-select" required>
                    <option value="Confirmed" {{ $reservasi->STATUS_RESERVASI == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="Selesai" {{ $reservasi->STATUS_RESERVASI == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Batal" {{ $reservasi->STATUS_RESERVASI == 'Batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Preferensi / Catatan Kunjungan</label>
            <input type="text" name="CATATAN_PREFERENSI" class="form-control" value="{{ $reservasi->CATATAN_PREFERENSI }}" placeholder="Contoh: Dekat jendela, ada kursi bayi">
        </div>

        <button type="submit" class="btn btn-warning text-white w-100 mt-3 py-2 fw-bold shadow-sm">Update Reservasi</button>
    </form>
</div>
@endsection