<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventaris Universitas') }}</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --sidebar-width: 250px;
        }
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e1b2e 0%, #161426 100%);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 50;
            overflow-y: auto;
            color: #94a3b8;
            transition: all 0.3s;
        }
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .topbar {
            height: 64px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 40;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
        }
        .sidebar-brand {
            height: 64px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 1.25rem;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.05em;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .brand-icon {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, #e11d48 0%, #fb7185 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }
        .sidebar-section-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #64748b;
            padding: 1.25rem 1.25rem 0.5rem;
            font-weight: 700;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0 0.75rem;
            margin: 0;
        }
        .sidebar-menu li {
            margin-bottom: 0.25rem;
        }
        .sidebar-menu a, .sidebar-menu button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.65rem 0.85rem;
            border-radius: 8px;
            font-size: 0.875rem;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
        }
        .sidebar-menu a:hover, .sidebar-menu button:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
        }
        .sidebar-menu a.active {
            background: linear-gradient(90deg, #f43f5e 0%, #e11d48 100%);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(225, 29, 72, 0.35);
        }
        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            position: sticky;
            bottom: 0;
            background: #161426;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* Card Component Styles */
        .card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        .card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-body {
            padding: 1.25rem;
        }
        .icon-box {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        /* Stat Grid */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }
        .stat-card-custom {
            border-radius: 12px;
            padding: 1.25rem;
            color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 110px;
        }
        .stat-card-custom .label {
            font-size: 0.825rem;
            opacity: 0.9;
            font-weight: 500;
        }
        .stat-card-custom .value {
            font-size: 2rem;
            font-weight: 700;
            margin-top: 0.25rem;
        }

        /* Tables & Badges */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #f8fafc;
            padding: 10px 14px;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 600;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        td {
            padding: 12px 14px;
            font-size: 0.875rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-warning { background: #fef3c7; color: #b45309; }
        .badge-danger { background: #fee2e2; color: #b91c1c; }
        .badge-info { background: #e0f2fe; color: #0369a1; }

        /* Form Inputs */
        .form-group {
            margin-bottom: 1rem;
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.4rem;
        }
        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-group .icon {
            position: absolute;
            left: 12px;
            color: #94a3b8;
            pointer-events: none;
        }
        .input-group input, .input-group select, .input-group textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 9px 12px 9px 38px;
            font-size: 0.875rem;
            color: #1e293b;
            background: #ffffff;
            outline: none;
            transition: border-color 0.2s;
        }
        .input-group input:focus, .input-group select:focus, .input-group textarea:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-primary {
            background: #4f46e5;
            color: white;
            border: 1px solid transparent;
        }
        .btn-primary:hover {
            background: #4338ca;
        }
        .btn-outline {
            background: white;
            color: #475569;
            border: 1px solid #cbd5e1;
        }
        .btn-outline:hover {
            background: #f8fafc;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="fas fa-boxes-stacked"></i>
            </div>
            <div>
                <span class="block text-xs uppercase tracking-wider text-rose-400 font-semibold">Inventaris</span>
                <span class="block text-sm font-bold text-white">UNIVERSITAS</span>
            </div>
        </div>

        <div class="py-2">
            <div class="sidebar-section-title">Menu Utama</div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie w-5"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                        <i class="fas fa-tags w-5"></i>
                        <span>Kategori</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">
                        <i class="fas fa-box w-5"></i>
                        <span>Barang</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-hand-holding-hand w-5"></i>
                        <span>Transaksi</span>
                    </a>
                </li>
            </ul>

            @if(Auth::check() && Auth::user()->role === 'admin')
                <div class="sidebar-section-title">Laporan</div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="#">
                            <i class="fas fa-file-pdf w-5 text-rose-400"></i>
                            <span>Barang PDF</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-file-pdf w-5 text-rose-400"></i>
                            <span>Transaksi PDF</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-file-excel w-5 text-emerald-400"></i>
                            <span>Barang Excel</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-file-excel w-5 text-emerald-400"></i>
                            <span>Transaksi Excel</span>
                        </a>
                    </li>
                </ul>
            @endif

            <div class="sidebar-section-title">Pengaturan Akun</div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="fas fa-user-gear w-5"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">
                            <i class="fas fa-arrow-right-from-bracket w-5 text-rose-400"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'User' }}</p>
                <span class="inline-block px-2 py-0.5 text-xs font-medium rounded {{ (Auth::user()->role ?? '') === 'admin' ? 'bg-rose-500/20 text-rose-300' : 'bg-blue-500/20 text-blue-300' }}">
                    {{ ucfirst(Auth::user()->role ?? 'Staff') }}
                </span>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <!-- Topbar -->
        <header class="topbar">
            <div class="flex items-center gap-3">
                <i class="far fa-calendar-alt text-gray-400"></i>
                <span class="text-sm font-medium text-gray-600">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? '' }}</span>
                <span class="user-avatar" style="width: 32px; height: 32px; font-size: 0.75rem;">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </span>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 flex-1">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
