<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - SISTEM PENILAIAN KARYAWAN PT.WASECO TIRTA</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            --sidebar-width: 270px;
            --primary-blue: #0d6efd;
            --dark-blue: #0b2447;
            --medium-blue: #19376d;
            --soft-bg: #f5f7fb;
            --text-dark: #212529;
            --text-muted: #6c757d;
            --border-soft: #edf0f3;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--soft-bg);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        /* ================= SIDEBAR ================= */

        .app-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #0b2447 0%, #19376d 58%, #0d6efd 100%);
            color: #fff;
            z-index: 1050;
            padding: 18px;
            overflow-y: auto;
            box-shadow: 8px 0 30px rgba(0, 0, 0, .14);
            transition: .3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 10px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, .14);
            margin-bottom: 18px;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: linear-gradient(135deg, #0d6efd, #4dabf7);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            box-shadow: 0 8px 22px rgba(13, 110, 253, .35);
            flex-shrink: 0;
        }

        .brand-title {
            font-size: 16px;
            font-weight: 800;
            line-height: 1.2;
            margin: 0;
            color: #fff;
        }

        .brand-subtitle {
            font-size: 12px;
            opacity: .75;
            margin: 2px 0 0;
        }

        .sidebar-section {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: rgba(255, 255, 255, .56);
            font-weight: 800;
            margin: 18px 10px 8px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 7px;
        }

        .sidebar-link {
            width: 100%;
            border: none;
            background: transparent;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 15px;
            color: rgba(255, 255, 255, .84);
            font-weight: 650;
            transition: .22s ease;
            text-align: left;
        }

        .sidebar-link i {
            font-size: 19px;
            width: 22px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-link span {
            font-size: 14px;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, .12);
            color: #fff;
            transform: translateX(3px);
        }

        .sidebar-link.active {
            background: #fff;
            color: var(--primary-blue);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .16);
        }

        .sidebar-footer {
            margin-top: 24px;
            padding: 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .12);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #fff;
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 14px;
            font-weight: 800;
            margin: 0;
            color: #fff;
        }

        .user-role {
            font-size: 12px;
            opacity: .75;
            margin: 0;
        }

        .logout-btn {
            background: rgba(255, 255, 255, .95);
            color: #0d6efd;
            border-radius: 12px;
            padding: 9px 12px;
            font-weight: 800;
            border: none;
            width: 100%;
            transition: .2s;
        }

        .logout-btn:hover {
            background: #fff;
            transform: translateY(-2px);
        }

        /* ================= MAIN WRAPPER ================= */

        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: .3s ease;
        }

        .topbar-modern {
            margin: 22px 24px 0;
            background: #fff;
            border-radius: 22px;
            padding: 18px 22px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .topbar-title h4 {
            margin: 0;
            font-size: 20px;
            font-weight: 850;
            color: #212529;
        }

        .topbar-title p {
            margin: 4px 0 0;
            font-size: 14px;
            color: #6c757d;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 15px;
            background: #f8f9fb;
            border: 1px solid #edf0f3;
        }

        .topbar-user-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd, #4dabf7);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .topbar-user-name {
            font-size: 13px;
            font-weight: 800;
            margin: 0;
            line-height: 1.2;
        }

        .topbar-user-role {
            font-size: 11px;
            color: #6c757d;
            margin: 0;
            line-height: 1.2;
        }

        .mobile-toggle {
            display: none;
            border: none;
            background: #e7f1ff;
            color: #0d6efd;
            width: 42px;
            height: 42px;
            border-radius: 13px;
            font-size: 21px;
            align-items: center;
            justify-content: center;
        }

        .page-content {
            padding: 24px;
        }

        /* ================= GLOBAL COMPONENTS ================= */

        .card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
        }

        .card-header {
            border-bottom: 1px solid var(--border-soft);
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
        }

        .alert {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .05);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table td,
        .table th {
            white-space: nowrap;
            font-size: 13px;
            vertical-align: middle;
        }

        .table td:nth-child(3),
        .table td:nth-child(4) {
            white-space: normal;
            min-width: 140px;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
        }

        /* ================= DASHBOARD WATERMARK SUPPORT ================= */

        .dashboard-bg {
            position: relative;
            min-height: 100vh;
            background: transparent;
        }

        .dashboard-bg::before {
            content: "";
            position: fixed;
            top: 50%;
            left: calc(50% + 120px);
            transform: translate(-50%, -50%);
            width: 500px;
            height: 500px;
            background: url('/img/waseco1.png') no-repeat center;
            background-size: contain;
            opacity: 0.08;
            z-index: 0;
            pointer-events: none;
        }

        .dashboard-overlay {
            background: transparent;
        }

        .dashboard-content {
            position: relative;
            z-index: 1;
        }

        .glass-card {
            background: rgba(255, 255, 255, .78) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, .50);
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .10);
        }

        .glass-card .card-header {
            background: transparent !important;
            border-bottom: 1px solid rgba(255, 255, 255, .35);
        }

        .glass-table {
            background: transparent !important;
        }

        .glass-table thead {
            background: rgba(255, 255, 255, .55);
        }

        .glass-table tbody tr {
            background: rgba(255, 255, 255, .30);
            transition: .2s;
        }

        .glass-table tbody tr:hover {
            background: rgba(255, 255, 255, .55);
        }

        /* ================= SIDEBAR OVERLAY MOBILE ================= */

        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 1040;
        }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 991px) {
            .app-sidebar {
                transform: translateX(-100%);
            }

            .app-sidebar.show {
                transform: translateX(0);
            }

            .sidebar-backdrop.show {
                display: block;
            }

            .main-wrapper {
                margin-left: 0;
            }

            .mobile-toggle {
                display: inline-flex;
            }

            .topbar-modern {
                margin: 16px 16px 0;
                padding: 14px 16px;
            }

            .topbar-user div:last-child {
                display: none;
            }

            .page-content {
                padding: 16px;
            }

            .dashboard-bg::before {
                left: 50%;
                width: 360px;
                height: 360px;
                opacity: .06;
            }
        }

        @media (max-width: 768px) {
            .topbar-title h4 {
                font-size: 17px;
            }

            .topbar-title p {
                font-size: 12px;
            }

            .table td,
            .table th {
                font-size: 12px;
            }

            .table th:nth-child(2),
            .table td:nth-child(2),
            .table th:nth-child(4),
            .table td:nth-child(4) {
                display: none;
            }
        }
    </style>

    @yield('styles')
</head>

<body>

    {{-- SIDEBAR --}}
    <aside class="app-sidebar" id="appSidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-bar-chart-line-fill"></i>
            </div>

            <div>
                <p class="brand-title">PT Waseco Tirta</p>
                <p class="brand-subtitle">Sistem Penilaian Karyawan</p>
            </div>
        </div>

        <div class="sidebar-section">Menu Utama</div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('dashboard') || request()->is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('karyawan.index') }}"
                    class="sidebar-link {{ request()->routeIs('karyawan.*') || request()->is('karyawan*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Data Karyawan</span>
                </a>
            </li>

            <li>
                <a href="{{ route('penilaian.index') }}"
                    class="sidebar-link {{ request()->routeIs('penilaian.*') || request()->is('penilaian*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check-fill"></i>
                    <span>Input Penilaian</span>
                </a>
            </li>

            <li>
                <a href="{{ route('hasil.index') }}"
                    class="sidebar-link {{ request()->routeIs('hasil.*') || request()->is('hasil*') ? 'active' : '' }}">
                    <i class="bi bi-trophy-fill"></i>
                    <span>Perhitungan & Hasil</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-section">Akun</div>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>

                <div>
                    <p class="user-name">{{ Auth::user()->name ?? 'Direktur Utama' }}</p>
                    <p class="user-role">Pengguna Sistem</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    {{-- MAIN WRAPPER --}}
    <main class="main-wrapper">

        {{-- TOPBAR --}}
        <div class="topbar-modern">
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="mobile-toggle" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>

                <div class="topbar-title">
                    <h4>@yield('page-title', 'Dashboard')</h4>
                    <p>@yield('page-subtitle', 'Sistem Penilaian Karyawan PT Waseco Tirta')</p>
                </div>
            </div>

            <div class="topbar-user">
                <div class="topbar-user-icon">
                    <i class="bi bi-person-fill"></i>
                </div>

                <div>
                    <p class="topbar-user-name">{{ Auth::user()->name ?? 'Direktur Utama' }}</p>
                    <p class="topbar-user-role">Pengguna Sistem</p>
                </div>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="page-content">

            @if(session('success'))
                <div class="alert alert-success mb-3">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-3">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </div>

    </main>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('appSidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function () {
                    sidebar.classList.add('show');
                    sidebarBackdrop.classList.add('show');
                });
            }

            if (sidebarBackdrop) {
                sidebarBackdrop.addEventListener('click', function () {
                    sidebar.classList.remove('show');
                    sidebarBackdrop.classList.remove('show');
                });
            }

            if ($.fn.DataTable) {
                $('.datatable').DataTable({
                    responsive: true,
                    pageLength: 10,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        zeroRecords: "Data tidak ditemukan",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        infoEmpty: "Tidak ada data",
                        infoFiltered: "(difilter dari _MAX_ total data)",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Berikutnya",
                            previous: "Sebelumnya"
                        }
                    }
                });
            }
        });

        function confirmDelete(form) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                form.submit();
                return true;
            }

            return false;
        }
    </script>

    @yield('scripts')
</body>

</html>