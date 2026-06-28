<!DOCTYPE html>
<html>
<head>
    <title>Vandeesa System</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #F5F3FF 0%, #FAF9FF 100%);
            color: #1F2937;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #7C5CDB 0%, #6B46C1 100%);
            color: white;
            position: fixed;
            padding: 30px 20px;
            box-sizing: border-box;
            box-shadow: 4px 0 15px rgba(123, 92, 219, 0.2);
            overflow-y: auto;
        }

        .sidebar h2 {
            margin-top: 0;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .sidebar a {
            display: block;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding-left: 20px;
        }

        .sidebar hr {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin: 20px 0;
        }

        .content {
            margin-left: 260px;
            padding: 40px;
            min-height: 100vh;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 12px rgba(123, 92, 219, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(123, 92, 219, 0.15);
        }

        /* Metric Card Styles */
        .metric-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 30px 25px;
            background: linear-gradient(135deg, #FFFFFF 0%, #F9F8FF 100%);
            border: 1px solid #E9D5FF;
        }

        .metric-card:hover {
            background: linear-gradient(135deg, #FAF9FF 0%, #F5F3FF 100%);
            border-color: #D8B4FE;
        }

        .metric-icon {
            font-size: 48px;
            margin-bottom: 15px;
            display: block;
            animation: float 3s ease-in-out infinite;
        }

        .metric-card:nth-child(1) .metric-icon { animation-delay: 0s; }
        .metric-card:nth-child(2) .metric-icon { animation-delay: 0.2s; }
        .metric-card:nth-child(3) .metric-icon { animation-delay: 0.4s; }
        .metric-card:nth-child(4) .metric-icon { animation-delay: 0.6s; }
        .metric-card:nth-child(5) .metric-icon { animation-delay: 0.8s; }
        .metric-card:nth-child(6) .metric-icon { animation-delay: 1s; }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-8px);
            }
        }

        .metric-card h3 {
            color: #6B46C1;
            margin-bottom: 10px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 0;
        }

        .metric-card .metric-value {
            font-size: 32px;
            font-weight: 700;
            color: #7C5CDB;
            margin: 8px 0;
        }

        .metric-card .metric-value.large-number {
            font-size: 48px;
        }

        .metric-card .subtitle {
            font-size: 12px;
            color: #9CA3AF;
            margin-top: 10px;
        }

        .metric-card.alert-card .metric-value {
            color: #EF4444;
        }

        .card h3 {
            color: #6B46C1;
            margin-bottom: 15px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card p {
            font-size: 28px;
            font-weight: 700;
            color: #7C5CDB;
            margin: 0;
        }

        .card .subtitle {
            font-size: 12px;
            color: #9CA3AF;
            margin-top: 8px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .grid-5 {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 25px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #1F2937;
            margin: 40px 0 25px 0;
            padding-bottom: 15px;
            border-bottom: 3px solid #E9D5FF;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 15px;
            border-bottom: 1px solid #E9D5FF;
            text-align: left;
            font-size: 14px;
        }

        th {
            background: linear-gradient(180deg, #F5F3FF 0%, #FAF9FF 100%);
            font-weight: 600;
            color: #6B46C1;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        tr:hover {
            background: #F5F3FF;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px 12px;
            margin-top: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 2px solid #E9D5FF;
            border-radius: 8px;
            font-family: inherit;
            transition: border-color 0.3s ease;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #7C5CDB;
            box-shadow: 0 0 0 3px rgba(123, 92, 219, 0.1);
        }

        button, .btn {
            padding: 10px 20px;
            background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
            color: white;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        button:hover, .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(123, 92, 219, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #9CA3AF 0%, #6B7280 100%);
        }

        .alert-success {
            background: linear-gradient(135deg, #DCFCE7 0%, #D1FAE5 100%);
            color: #166534;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #10B981;
        }

        .alert-error {
            background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
            color: #991B1B;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #EF4444;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-waiting {
            background: #FEF3C7;
            color: #B45309;
        }

        .status-processing {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .status-shipped {
            background: #E0E7FF;
            color: #3730A3;
        }

        .status-completed {
            background: #DCFCE7;
            color: #166534;
        }

        .status-cancelled {
            background: #FEE2E2;
            color: #991B1B;
        }

        h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 10px;
        }

        .greeting {
            color: #6B7280;
            font-size: 14px;
            margin-bottom: 30px;
        }

        /* Sidebar Toggle Styles */
        .sidebar-toggle {
            position: absolute;
            top: 30px;
            right: 15px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .sidebar-toggle:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .sidebar {
            transition: all 0.3s ease;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: 100px;
            padding: 30px 10px;
            align-items: center;
        }

        .sidebar.collapsed h2 {
            font-size: 32px;
            margin-bottom: 20px;
            text-align: center;
            letter-spacing: 0;
        }

        .sidebar.collapsed .menu-text {
            display: none;
        }

        .sidebar.collapsed a {
            width: 50px;
            height: 50px;
            padding: 0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            position: relative;
            margin-bottom: 12px;
        }

        .sidebar.collapsed a:hover {
            background: rgba(255, 255, 255, 0.25);
            padding-left: 12px;
        }

        .sidebar.collapsed a::after {
            content: attr(data-label);
            position: absolute;
            left: 70px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            white-space: nowrap;
            font-size: 12px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 1000;
        }

        .sidebar.collapsed a:hover::after {
            opacity: 1;
        }

        .sidebar.collapsed hr {
            width: 30px;
            margin: 15px auto;
            opacity: 0.5;
        }

        .content {
            transition: all 0.3s ease;
        }

        .content.expanded {
            margin-left: 260px;
        }

        .content.collapsed {
            margin-left: 100px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-item-icon {
            font-size: 18px;
            min-width: 24px;
            text-align: center;
        }

    </style>
</head>

<body>

<div class="sidebar" id="sidebar">
    <button class="sidebar-toggle" id="sidebarToggle" title="Toggle sidebar">
        <span>‹</span>
    </button>
    <br>
    <br>
    <br>
    <a href="{{ route('dashboard') }}" class="menu-link" data-label="Dashboard">
        <span class="menu-item-icon">📊</span>
        <span class="menu-text">Dashboard</span>
    </a>

    <hr>

    @auth
        @if(auth()->user()->role === 'admin')
            <!-- Admin Menu -->
            <a href="{{ route('item.index') }}" class="menu-link" data-label="Data Item">
                <span class="menu-item-icon">📦</span>
                <span class="menu-text">Data Item</span>
            </a>
            <a href="{{ route('pegawai.index') }}" class="menu-link" data-label="Data Pegawai">
                <span class="menu-item-icon">👔</span>
                <span class="menu-text">Data Pegawai</span>
            </a>
            <a href="{{ route('pelanggan.index') }}" class="menu-link" data-label="Data Pelanggan">
                <span class="menu-item-icon">👥</span>
                <span class="menu-text">Data Pelanggan</span>
            </a>
            <a href="{{ route('member.index') }}" class="menu-link" data-label="Data Member">
                <span class="menu-item-icon">⭐</span>
                <span class="menu-text">Data Member</span>
            </a>
            <a href="{{ route('reseller.index') }}" class="menu-link" data-label="Data Reseller">
                <span class="menu-item-icon">🤝</span>
                <span class="menu-text">Data Reseller</span>
            </a>

            <hr>

            <a href="{{ route('invoice.index') }}" class="menu-link" data-label="Invoice Penjualan">
                <span class="menu-item-icon">📄</span>
                <span class="menu-text">Invoice Penjualan</span>
            </a>
            <a href="{{ route('delivery.index') }}" class="menu-link" data-label="Delivery Order">
                <span class="menu-item-icon">🚚</span>
                <span class="menu-text">Delivery Order</span>
            </a>

            <hr>

            <a href="{{ route('laporan.penjualan') }}" class="menu-link" data-label="Laporan Penjualan">
                <span class="menu-item-icon">📈</span>
                <span class="menu-text">Laporan Penjualan</span>
            </a>
            <a href="{{ route('laporan.stok') }}" class="menu-link" data-label="Laporan Stok">
                <span class="menu-item-icon">📊</span>
                <span class="menu-text">Laporan Stok</span>
            </a>
            <a href="{{ route('laporan.delivery') }}" class="menu-link" data-label="Laporan Delivery">
                <span class="menu-item-icon">📋</span>
                <span class="menu-text">Laporan Delivery</span>
            </a>

        @elseif(auth()->user()->role === 'kasir')
            <!-- Kasir Menu -->
            <a href="{{ route('kasir.items') }}" class="menu-link" data-label="Katalog Item">
                <span class="menu-item-icon">🛍️</span>
                <span class="menu-text">Katalog Item</span>
            </a>
            <a href="{{ route('invoice.index') }}" class="menu-link" data-label="Invoice Penjualan">
                <span class="menu-item-icon">📄</span>
                <span class="menu-text">Invoice Penjualan</span>
            </a>

        @elseif(auth()->user()->role === 'owner')
            <!-- Owner Menu -->
            <a href="{{ route('delivery.index') }}" class="menu-link" data-label="Delivery Order">
                <span class="menu-item-icon">🚚</span>
                <span class="menu-text">Delivery Order</span>
            </a>
            <hr>
            <a href="{{ route('laporan.penjualan') }}" class="menu-link" data-label="Laporan Penjualan">
                <span class="menu-item-icon">📈</span>
                <span class="menu-text">Laporan Penjualan</span>
            </a>
            <a href="{{ route('laporan.stok') }}" class="menu-link" data-label="Laporan Stok">
                <span class="menu-item-icon">📊</span>
                <span class="menu-text">Laporan Stok</span>
            </a>
            <a href="{{ route('laporan.delivery') }}" class="menu-link" data-label="Laporan Delivery">
                <span class="menu-item-icon">📋</span>
                <span class="menu-text">Laporan Delivery</span>
            </a>
        @endif

        <!-- Separator & User Info -->
        <hr style="margin-top: auto; margin-bottom: 15px;">

        <!-- User Info & Logout -->
        <div style="padding: 12px 0; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 15px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; padding: 0 10px;">
                <div style="width: 36px; height: 36px; background: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    👤
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-size: 12px; opacity: 0.7;">{{ auth()->user()->username }}</div>
                    <div style="font-size: 11px; opacity: 0.6; text-transform: capitalize;">{{ auth()->user()->role }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                @csrf
                <button type="submit" class="menu-link" style="width: 100%; text-align: left; background: rgba(255,255,255,0.1); border: none; cursor: pointer; margin: 0;" data-label="Logout">
                    <span class="menu-item-icon">🚪</span>
                    <span class="menu-text">Logout</span>
                </button>
            </form>
        </div>
    @endauth
</div>

<div class="content expanded" id="content">
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @yield('content')
</div>

<script>
    // Sidebar Toggle Functionality
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const sidebarToggle = document.getElementById('sidebarToggle');

    // Check localStorage for sidebar state
    const sidebarState = localStorage.getItem('sidebarCollapsed');
    if (sidebarState === 'true') {
        sidebar.classList.add('collapsed');
        content.classList.remove('expanded');
        content.classList.add('collapsed');
        sidebarToggle.innerHTML = '›';
    }

    // Toggle sidebar on button click
    sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('expanded');
        content.classList.toggle('collapsed');

        // Update button icon
        if (sidebar.classList.contains('collapsed')) {
            sidebarToggle.innerHTML = '›';
            localStorage.setItem('sidebarCollapsed', 'true');
        } else {
            sidebarToggle.innerHTML = '‹';
            localStorage.setItem('sidebarCollapsed', 'false');
        }
    });
</script>

</body>
</html>
