<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Resto Sedap Rasa')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- DataTables Bootstrap 5 + Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --primary-color: #ea580c; /* Warm Terracotta / Orange Bistro */
            --primary-hover: #c2410c;
            --sidebar-bg: #ffffff;
            --bg-canvas: #f8fafc;
            --border-subtle: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-canvas);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            min-width: 255px;
            max-width: 255px;
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-subtle);
        }

        .sidebar .brand-title {
            font-weight: 700;
            font-size: 1.15rem;
            color: var(--text-main);
        }

        .sidebar .nav-link {
            color: var(--text-muted);
            padding: 10px 16px;
            border-radius: 8px;
            margin-bottom: 4px;
            font-weight: 500;
            font-size: 0.92rem;
            transition: all 0.15s ease-in-out;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover {
            color: var(--primary-color);
            background-color: #fff7ed;
        }

        .sidebar .nav-link.active {
            color: #ffffff !important;
            background-color: var(--primary-color) !important;
            font-weight: 600;
        }

        /* Top Navbar */
        .top-navbar {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-subtle);
        }

        /* Clean Card Styling */
        .card {
            background-color: #ffffff;
            border: 1px solid var(--border-subtle) !important;
            border-radius: 12px !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px -1px rgba(0, 0, 0, 0.02) !important;
        }

        /* Custom Table Styling */
        .table thead th {
            background-color: #f8fafc !important;
            color: #475569 !important;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border-subtle) !important;
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .table td {
            padding-top: 14px;
            padding-bottom: 14px;
            border-color: #f1f5f9;
            font-size: 0.92rem;
            vertical-align: middle;
        }

        /* Button Custom Primary */
        .btn-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover) !important;
            border-color: var(--primary-hover) !important;
        }

        .dt-buttons .btn {
            margin-right: 5px;
            margin-bottom: 10px;
            border-radius: 6px;
        }

        /* Credit Box Sidebar */
        .credit-box {
            background-color: #f8fafc;
            border: 1px solid var(--border-subtle);
            border-radius: 10px;
            padding: 10px 12px;
        }
    </style>
</head>
<body class="d-flex">

    <!-- SIDEBAR -->
    <div class="sidebar d-flex flex-column p-3">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none px-2 pt-2">
            <span class="brand-title">🍽️ Resto Sedap</span>
        </a>
        <hr class="text-muted opacity-25 my-3">

        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                    <i class="bi bi-grid me-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="/reservasi" class="nav-link {{ Request::is('reservasi*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event me-2"></i> Reservasi
                </a>
            </li>
            <li>
                <a href="/menu" class="nav-link {{ Request::is('menu*') ? 'active' : '' }}">
                    <i class="bi bi-cup-hot me-2"></i> Daftar Menu
                </a>
            </li>
            <li>
                <a href="/pelanggan" class="nav-link {{ Request::is('pelanggan*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i> Pelanggan
                </a>
            </li>
            <li>
                <a href="/meja" class="nav-link {{ Request::is('meja*') ? 'active' : '' }}">
                    <i class="bi bi-aspect-ratio me-2"></i> Daftar Meja
                </a>
            </li>
        </ul>

        <hr class="text-muted opacity-25 my-3">

        <!-- CREDIT SECTION (SIDEBAR) -->
        <div class="credit-box">
            <div class="text-muted" style="font-size: 0.72rem; letter-spacing: 0.03em; text-transform: uppercase;">Developed By</div>
            <div class="fw-semibold text-dark" style="font-size: 0.85rem;">Nafa Rahmadianty Ayoghi</div>
            <div class="text-muted" style="font-size: 0.75rem;">&copy; 2026</div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-grow-1 min-vh-100 d-flex flex-column">
        <nav class="navbar top-navbar px-4 py-3 shadow-none">
            <div class="container-fluid p-0 d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold text-dark">@yield('title', 'Dashboard')</h5>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill font-monospace">
                        <i class="bi bi-person-badge text-primary me-1"></i> Admin / Kasir
                    </span>
                </div>
            </div>
        </nav>

        <div class="p-4 flex-grow-1">
            @yield('content')
        </div>

        <!-- FOOTER BAR -->
        <footer class="px-4 py-3 bg-white border-top text-muted d-flex justify-content-end align-items-center" style="font-size: 0.82rem;">
            <span>Created by <strong class="text-dark">Nafa Rahmadianty Ayoghi</strong> &copy; 2026</span>
        </footer>
    </div>

    <!-- JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables & Extensions -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Perhatian!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#ea580c'
            });
        @endif

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus Data!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>