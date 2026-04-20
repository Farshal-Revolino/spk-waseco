<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SISTEM PENILAIAN KARYAWAN PT.WASECO TIRTA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            --sidebar-width: 240px;
            --primary: #1a56a0;
        }


        /* SIDEBAR */
        .sidebar {
            position: fixed;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #0d3b7a 0%, #1a56a0 60%, #1e6bbf 100%);
            color: white;
            display: flex;
            flex-direction: column;
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.2);
        }


        .sidebar-logo {
            padding: 25px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .sidebar-logo h4 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
        }

        .sidebar-logo small {
            font-size: 0.75rem;
            opacity: 0.7;
        }

        .sidebar-nav {
            padding: 15px 10px;
            flex: 1;
        }

        .nav-label {
            font-size: 0.7rem;
            opacity: 0.5;
            text-transform: uppercase;
            padding: 10px 12px 5px;
            font-weight: 600;
        }

        .nav-link {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.85);
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 4px;
            text-decoration: none;
            transition: 0.2s;
        }

        .nav-link i {
            width: 24px;
            margin-right: 10px;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* MAIN */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .page-content {
            padding: 25px;
            flex: 1;
        }

        .alert {
            border-radius: 10px;
        }
    </style>

    @yield('styles')
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <h4>Fardian Ganteng</h4>
            <small>Sistem Penilaian Karyawan</small>
        </div>

        <nav class="sidebar-nav">


            <div class="nav-label">Menu Utama</div>

            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a class="nav-link {{ request()->is('karyawan*') ? 'active' : '' }}" href="{{ route('karyawan.index') }}">
                <i class="bi bi-people-fill"></i> Data Karyawan
            </a>

            <a class="nav-link {{ request()->is('penilaian*') ? 'active' : '' }}" href="{{ route('penilaian.index') }}">
                <i class="bi bi-clipboard-data-fill"></i> Input Penilaian
            </a>

            <a class="nav-link {{ request()->is('hasil*') ? 'active' : '' }}" href="{{ route('hasil.index') }}">
                <i class="bi bi-bar-chart-fill"></i> Perhitungan & Hasil
            </a>

            <!-- AKUN -->
            <div class="nav-label mt-4">AKUN</div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </form>

        </nav>
    </div>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">

        <div class="topbar">
            <div>
                <strong>@yield('page-title', 'Dashboard')</strong>
            </div>
            <div>
                <i class="bi bi-person-circle"></i>
                {{ Auth::user()->name ?? 'DIREKTUR UTAMA' }}
            </div>
        </div>

        <div class="page-content">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>

</html>