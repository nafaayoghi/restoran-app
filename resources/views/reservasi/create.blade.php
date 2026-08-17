@extends('layouts.app')

@section('title', 'Tambah Reservasi Baru')

@section('content')
<!-- TomSelect CSS untuk Searchable Dropdown -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

<div class="card shadow-sm p-4 bg-white col-md-9 mx-auto">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0 text-dark">Tambah Reservasi & Pesanan</h3>
        <a href="/reservasi" class="btn btn-secondary">Kembali</a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="/reservasi/store" method="POST" id="formReservasi">
        @csrf
        
        <h5 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="bi bi-person-lines-fill me-2"></i>Informasi Reservasi</h5>

        <div class="row">
            <!-- Searchable Pelanggan -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Pelanggan (Ketik Nama / No HP)</label>
                <select name="ID_PELANGGAN" id="select-pelanggan" placeholder="Ketik untuk mencari pelanggan..." required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($pelanggan as $p)
                        <option value="{{ $p->ID_PELANGGAN }}" {{ $p->IS_BLACKLIST ? 'disabled' : '' }}>
                            {{ $p->NAMA_PELANGGAN }} ({{ $p->NOMOR_TELEPON }}) {{ $p->IS_BLACKLIST ? ' - [DIBLACKLIST]' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Searchable Meja -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Nomor Meja (Ketik Nomor Meja)</label>
                <select name="NOMOR_MEJA" id="select-meja" placeholder="Ketik nomor meja..." required>
                    <option value="">-- Pilih Meja --</option>
                    @foreach($meja as $m)
                        <option value="{{ $m->NOMOR_MEJA }}" data-kapasitas="{{ $m->KAPASITAS_MEJA }}">
                            Meja {{ $m->NOMOR_MEJA }} (Kapasitas: {{ $m->KAPASITAS_MEJA }} orang)
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Tanggal Reservasi</label>
                <input type="date" name="TANGGAL_RESERVASI" class="form-control" value="{{ old('TANGGAL_RESERVASI', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Waktu (09:00 - 22:00)</label>
                <input type="time" name="WAKTU_RESERVASI" class="form-control" value="{{ old('WAKTU_RESERVASI', '12:00') }}" min="09:00" max="22:00" required>
            </div>
            
            <!-- Real-time Validated Jumlah Orang -->
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Jumlah Orang (Tamu)</label>
                <input type="number" name="JUMLAH_ORANG" id="input-jumlah-orang" class="form-control" min="1" value="{{ old('JUMLAH_ORANG', 1) }}" required>
                <div id="kapasitas-warning" class="text-danger small mt-1 fw-bold d-none">
                    <i class="bi bi-x-circle-fill"></i> Melebihi kapasitas meja (<span id="kapasitas-max">0</span> orang)!
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Preferensi / Permintaan Khusus Kunjungan</label>
                <input type="text" name="CATATAN_PREFERENSI" class="form-control" placeholder="Contoh: Meja dekat jendela, sediakan baby chair, rayakan ultah" value="{{ old('CATATAN_PREFERENSI') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Status Reservasi</label>
                <select name="STATUS_RESERVASI" class="form-select" required>
                    <option value="Confirmed" {{ old('STATUS_RESERVASI') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="Selesai" {{ old('STATUS_RESERVASI') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Batal" {{ old('STATUS_RESERVASI') == 'Batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
        </div>

        <!-- PILIHAN MENU AWAL -->
        <h5 class="fw-bold text-primary border-bottom pb-2 mt-4 mb-3"><i class="bi bi-cart-plus me-2"></i>Pesan Menu Sekaligus (Ketik Menu)</h5>
        <div id="menu-wrapper">
            <div class="row mb-3 menu-item-row align-items-center">
                <div class="col-md-7">
                    <select name="ID_MENU[]" class="menu-search-select" placeholder="Ketik nama menu...">
                        <option value="">-- Pilih Menu (Opsional) --</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->ID_MENU }}">{{ $menu->NAMA_MENU }} (Rp {{ number_format($menu->HARGA_MENU, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="JUMLAH_MENU[]" class="form-control" min="1" placeholder="Jumlah Porsi">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-success w-100" id="btn-add-menu">+ Baris</button>
                </div>
            </div>
        </div>

        <button type="submit" id="btn-submit" class="btn btn-primary w-100 mt-4 py-2 fs-5 fw-bold shadow-sm">Simpan Reservasi</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    // 1. Inisialisasi Searchable Dropdown TomSelect
    new TomSelect('#select-pelanggan', { create: false, sortField: { field: "text", direction: "asc" } });
    
    let mejaSelect = new TomSelect('#select-meja', {
        create: false,
        onChange: function(value) {
            validateCapacity();
        }
    });

    function initMenuSelect(element) {
        new TomSelect(element, { create: false });
    }
    document.querySelectorAll('.menu-search-select').forEach(el => initMenuSelect(el));

    // 2. Real-time Capacity Validation (Validasi Langsung Saat Ketik)
    const jumlahInput = document.getElementById('input-jumlah-orang');
    const warningDiv = document.getElementById('kapasitas-warning');
    const kapasitasMaxSpan = document.getElementById('kapasitas-max');
    const submitBtn = document.getElementById('btn-submit');

    function validateCapacity() {
        let selectedOption = document.querySelector('#select-meja option:checked');
        if (!selectedOption || !selectedOption.dataset.kapasitas) {
            return;
        }

        let maxKapasitas = parseInt(selectedOption.dataset.kapasitas);
        let jumlahOrang = parseInt(jumlahInput.value) || 0;
        kapasitasMaxSpan.innerText = maxKapasitas;

        if (jumlahOrang > maxKapasitas) {
            jumlahInput.classList.add('is-invalid');
            warningDiv.classList.remove('d-none');
            submitBtn.disabled = true;
            submitBtn.classList.add('btn-secondary');
            submitBtn.classList.remove('btn-primary');
        } else {
            jumlahInput.classList.remove('is-invalid');
            warningDiv.classList.add('d-none');
            submitBtn.disabled = false;
            submitBtn.classList.remove('btn-secondary');
            submitBtn.classList.add('btn-primary');
        }
    }

    jumlahInput.addEventListener('input', validateCapacity);

    // 3. Tambah Baris Menu Dinamis
    document.getElementById('btn-add-menu').addEventListener('click', function() {
        let wrapper = document.getElementById('menu-wrapper');
        let newRow = document.createElement('div');
        newRow.className = 'row mb-3 menu-item-row align-items-center';
        newRow.innerHTML = `
            <div class="col-md-7">
                <select name="ID_MENU[]" class="menu-search-select" placeholder="Ketik nama menu...">
                    <option value="">-- Pilih Menu --</option>
                    @foreach($menus as $menu)
                        <option value="{{ $menu->ID_MENU }}">{{ $menu->NAMA_MENU }} (Rp {{ number_format($menu->HARGA_MENU, 0, ',', '.') }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="JUMLAH_MENU[]" class="form-control" min="1" value="1" placeholder="Jumlah Porsi">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.menu-item-row').remove()">- Hapus</button>
            </div>
        `;
        wrapper.appendChild(newRow);
        initMenuSelect(newRow.querySelector('.menu-search-select'));
    });
</script>
@endsection