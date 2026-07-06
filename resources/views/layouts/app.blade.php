<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vandeesa System</title>
    
    <!-- Google Fonts & Lucide Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --bg-sidebar: #EBE7FA;
            --primary-purple: #705DF2;
            --hover-purple: #DFD7FA;
            --active-purple: #CFC4FA;
            --text-dark: #221B47;
            --text-muted: #62598F;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 88px;
            --transition-smooth: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #FBFBFF 0%, #F5F3FF 100%);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
        }

        /* --- SIDEBAR CONTAINER --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--bg-sidebar);
            border-right: 1px solid rgba(139, 124, 246, 0.15);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 24px 18px;
            z-index: 100;
            transition: var(--transition-smooth);
            box-shadow: 4px 0 24px rgba(139, 124, 246, 0.03);
        }

        /* Collapsed State */
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
            padding: 24px 14px;
        }

        /* --- SIDEBAR HEADER / BRANDING --- */
        .sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            padding: 0 8px;
            position: relative;
        }

        .brand-logo-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            overflow: hidden;
            transition: var(--transition-smooth);
        }

        .brand-logo {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, #A78BFA, #8B7CF6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 4px 12px rgba(139, 124, 246, 0.3);
            flex-shrink: 0;
        }

        .brand-logo svg {
            width: 20px;
            height: 20px;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 21px;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.2px;
            white-space: nowrap;
            opacity: 1;
            transition: var(--transition-smooth);
        }

        .sidebar.collapsed .brand-name {
            opacity: 0;
            width: 0;
            pointer-events: none;
        }

        .sidebar-main-logo {
            width: 160px;
            height: auto;
            max-width: 100%;
            transition: var(--transition-smooth);
            object-fit: contain;
        }

        .sidebar.collapsed .sidebar-main-logo {
            width: 50px;
        }

        /* --- COLLAPSE BUTTON --- */
        .sidebar-toggle-btn {
            background: white;
            border: 1px solid rgba(139, 124, 246, 0.2);
            color: var(--primary-purple);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition-smooth);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
            position: absolute;
            right: -28px;
            top: 5px;
        }

        .sidebar-toggle-btn:hover {
            background: var(--primary-purple);
            color: white;
            transform: scale(1.1);
        }

        .sidebar.collapsed .sidebar-toggle-btn {
            right: -28px;
        }

        .sidebar-toggle-btn svg {
            width: 14px;
            height: 14px;
            transition: var(--transition-smooth);
        }

        .sidebar.collapsed .sidebar-toggle-btn svg {
            transform: rotate(180deg);
        }

        /* --- MENU SECTION --- */
        .sidebar-menu-wrapper {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            margin-right: -8px;
            padding-right: 8px;
        }

        /* Scrollbar styles for menu wrapper */
        .sidebar-menu-wrapper::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-menu-wrapper::-webkit-scrollbar-thumb {
            background: rgba(139, 124, 246, 0.15);
            border-radius: 10px;
        }

        .menu-group {
            margin-bottom: 24px;
        }

        .menu-group-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            margin-bottom: 10px;
            padding-left: 12px;
            opacity: 1;
            transition: var(--transition-smooth);
            white-space: nowrap;
        }

        .sidebar.collapsed .menu-group-title {
            opacity: 0;
            height: 0;
            margin-bottom: 0;
            overflow: hidden;
        }

        /* --- MENU LINKS --- */
        .menu-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 14px;
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            transition: var(--transition-smooth);
            margin-bottom: 4px;
            position: relative;
            white-space: nowrap;
        }

        .menu-link:hover {
            background-color: var(--hover-purple);
            color: var(--primary-purple);
        }

        .menu-link.active {
            background-color: var(--active-purple);
            color: var(--primary-purple);
        }

        .menu-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 25%;
            height: 50%;
            width: 4px;
            background-color: var(--primary-purple);
            border-radius: 0 4px 4px 0;
        }

        .menu-icon {
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: inherit;
            flex-shrink: 0;
        }

        .menu-text {
            opacity: 1;
            transition: var(--transition-smooth);
        }

        .sidebar.collapsed .menu-text {
            opacity: 0;
            width: 0;
            pointer-events: none;
        }

        /* Collapsed Tooltip labels */
        .sidebar.collapsed .menu-link::after {
            content: attr(data-label);
            position: absolute;
            left: 78px;
            background: #1e1b4b;
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease, transform 0.25s ease;
            transform: translateX(-8px);
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .sidebar.collapsed .menu-link:hover::after {
            opacity: 1;
            transform: translateX(0);
        }

        /* --- USER PROFILE SECTION --- */
        .sidebar-footer {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid rgba(139, 124, 246, 0.15);
            position: relative;
        }

        .user-profile-trigger {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border-radius: 14px;
            cursor: pointer;
            transition: var(--transition-smooth);
            width: 100%;
            background: none;
            border: none;
            text-align: left;
        }

        .user-profile-trigger:hover {
            background-color: var(--hover-purple);
        }

        .user-avatar-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #DDD6FE, #C7D2FE);
            color: var(--primary-purple);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            border: 2px solid white;
            box-shadow: 0 4px 10px rgba(139,124,246,0.15);
        }

        .user-avatar svg {
            width: 20px;
            height: 20px;
        }

        .user-status-dot {
            width: 10px;
            height: 10px;
            background-color: #10B981;
            border: 2px solid var(--bg-sidebar);
            border-radius: 50%;
            position: absolute;
            bottom: -2px;
            right: -2px;
        }

        .user-details {
            flex: 1;
            min-width: 0;
            opacity: 1;
            transition: var(--transition-smooth);
            display: flex;
            flex-direction: column;
        }

        .sidebar.collapsed .user-details {
            opacity: 0;
            width: 0;
            pointer-events: none;
        }

        .user-name {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--text-dark);
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .user-role-badge {
            font-size: 11px;
            font-weight: 600;
            color: var(--primary-purple);
            text-transform: capitalize;
            margin-top: 1px;
        }

        .chevron-up-icon {
            color: var(--text-muted);
            transition: var(--transition-smooth);
        }

        .sidebar.collapsed .chevron-up-icon {
            display: none;
        }

        /* --- DROPDOWN PROFILE --- */
        .profile-dropdown {
            position: absolute;
            bottom: calc(100% + 8px);
            left: 0;
            width: 100%;
            background: white;
            border: 1px solid rgba(139, 124, 246, 0.15);
            border-radius: 14px;
            padding: 8px;
            box-shadow: 0 -10px 25px rgba(139, 124, 246, 0.08), 0 10px 20px rgba(0, 0, 0, 0.03);
            display: none;
            flex-direction: column;
            gap: 4px;
            z-index: 120;
            animation: slideUpDropdown 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.collapsed .profile-dropdown {
            width: 180px;
            left: 10px;
        }

        @keyframes slideUpDropdown {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .profile-dropdown.show {
            display: flex;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            text-decoration: none;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .dropdown-item:hover {
            background-color: var(--hover-purple);
            color: var(--primary-purple);
        }

        .dropdown-item-danger {
            color: #EF4444;
        }

        .dropdown-item-danger:hover {
            background-color: #FEF2F2;
            color: #EF4444;
        }

        .dropdown-divider {
            height: 1px;
            background-color: rgba(139, 124, 246, 0.1);
            margin: 4px 0;
        }

        /* --- CONTENT MAIN WRAPPER --- */
        .content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 40px;
            min-height: 100vh;
            transition: var(--transition-smooth);
        }

        .content.collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Mobile Trigger Button */
        .mobile-header {
            display: none;
            height: 60px;
            background: white;
            border-bottom: 1px solid rgba(139, 124, 246, 0.15);
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 99;
        }

        .mobile-menu-btn {
            background: none;
            border: none;
            color: var(--primary-purple);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Responsive Breakpoints */
        @media (max-width: 992px) {
            .content {
                padding: 30px 20px;
            }
        }

        @media (max-width: 768px) {
            .mobile-header {
                display: flex;
            }
            .sidebar {
                transform: translateX(-100%);
                height: 100vh;
                top: 0;
                box-shadow: 10px 0 30px rgba(0,0,0,0.08);
            }
            .sidebar.mobile-show {
                transform: translateX(0);
            }
            .content {
                margin-left: 0 !important;
                padding: 90px 16px 40px 16px;
            }
            .sidebar-toggle-btn {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- Mobile Header Navigation -->
    <div class="mobile-header">
        <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Buka Menu">
            <i data-lucide="menu" style="width: 26px; height: 26px;"></i>
        </button>
        <div style="font-family: 'Playfair Display', serif; font-size: 19px; font-weight: 700; color: var(--text-dark);">
            Vandeesa
        </div>
        <div style="width: 26px;"></div> <!-- Spacer -->
    </div>

    <!-- Sidebar Navigation -->
    <div class="sidebar" id="sidebar">
        <!-- Brand Header -->
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}" class="brand-logo-wrapper" style="justify-content: center; width: 100%;">
                <img src="{{ asset('images/items/LOGO VANDEESA.png') }}" alt="Logo" class="sidebar-main-logo">
            </a>
            <button class="sidebar-toggle-btn" id="sidebarToggle" title="Sembunyikan Sidebar">
                <i data-lucide="chevron-left"></i>
            </button>
        </div>

        <!-- Menu wrapper -->
        <div class="sidebar-menu-wrapper">
            @auth
                <!-- SECTION: MAIN MENU -->
                <div class="menu-group">
                    <div class="menu-group-title">Main Menu</div>
                    <a href="{{ route('dashboard') }}" class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-label="Dashboard">
                        <span class="menu-icon"><i data-lucide="layout-dashboard"></i></span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </div>

                @if(auth()->user()->role === 'admin')
                    <!-- SECTION: MASTER DATA (ADMIN) -->
                    <div class="menu-group">
                        <div class="menu-group-title">Master Data</div>
                        <a href="{{ route('item.index') }}" class="menu-link {{ request()->routeIs('item.*') ? 'active' : '' }}" data-label="Data Item">
                            <span class="menu-icon"><i data-lucide="package"></i></span>
                            <span class="menu-text">Data Item</span>
                        </a>
                        <a href="{{ route('pegawai.index') }}" class="menu-link {{ request()->routeIs('pegawai.*') ? 'active' : '' }}" data-label="Data Pegawai">
                            <span class="menu-icon"><i data-lucide="user-square-2"></i></span>
                            <span class="menu-text">Data Pegawai</span>
                        </a>

                        <a href="{{ route('member.index') }}" class="menu-link {{ request()->routeIs('member.*') ? 'active' : '' }}" data-label="Data Member">
                            <span class="menu-icon"><i data-lucide="award"></i></span>
                            <span class="menu-text">Data Member</span>
                        </a>
                        <a href="{{ route('reseller.index') }}" class="menu-link {{ request()->routeIs('reseller.*') ? 'active' : '' }}" data-label="Data Reseller">
                            <span class="menu-icon"><i data-lucide="handshake"></i></span>
                            <span class="menu-text">Data Reseller</span>
                        </a>
                    </div>

                    <!-- SECTION: TRANSAKSI (ADMIN) -->
                    <div class="menu-group">
                        <div class="menu-group-title">Transaksi</div>
                        <a href="{{ route('invoice.index') }}" class="menu-link {{ request()->routeIs('invoice.*') ? 'active' : '' }}" data-label="Invoice Penjualan">
                            <span class="menu-icon"><i data-lucide="file-text"></i></span>
                            <span class="menu-text">Invoice Penjualan</span>
                        </a>
                        <a href="{{ route('delivery.index') }}" class="menu-link {{ request()->routeIs('delivery.*') ? 'active' : '' }}" data-label="Delivery Order">
                            <span class="menu-icon"><i data-lucide="truck"></i></span>
                            <span class="menu-text">Delivery Order</span>
                        </a>
                    </div>

                    <!-- SECTION: LAPORAN (ADMIN) -->
                    <div class="menu-group">
                        <div class="menu-group-title">Laporan</div>
                        <a href="{{ route('laporan.penjualan') }}" class="menu-link {{ request()->routeIs('laporan.penjualan') ? 'active' : '' }}" data-label="Laporan Penjualan">
                            <span class="menu-icon"><i data-lucide="line-chart"></i></span>
                            <span class="menu-text">Laporan Penjualan</span>
                        </a>
                        <a href="{{ route('laporan.stok') }}" class="menu-link {{ request()->routeIs('laporan.stok') ? 'active' : '' }}" data-label="Laporan Stok">
                            <span class="menu-icon"><i data-lucide="bar-chart-3"></i></span>
                            <span class="menu-text">Laporan Stok</span>
                        </a>
                        <a href="{{ route('laporan.delivery') }}" class="menu-link {{ request()->routeIs('laporan.delivery') ? 'active' : '' }}" data-label="Laporan Delivery">
                            <span class="menu-icon"><i data-lucide="clipboard-list"></i></span>
                            <span class="menu-text">Laporan Delivery</span>
                        </a>
                    </div>

                @elseif(auth()->user()->role === 'kasir')


                    <!-- SECTION: TRANSAKSI (KASIR) -->
                    <div class="menu-group">
                        <div class="menu-group-title">Transaksi</div>
                        <a href="{{ route('kasir.items') }}" class="menu-link {{ request()->routeIs('kasir.items') ? 'active' : '' }}" data-label="Mesin Kasir (POS)">
                            <span class="menu-icon"><i data-lucide="calculator"></i></span>
                            <span class="menu-text">Mesin Kasir (POS)</span>
                        </a>
                    </div>

                @elseif(auth()->user()->role === 'owner')
                    <!-- SECTION: LAPORAN (OWNER) -->
                    <div class="menu-group">
                        <div class="menu-group-title">Laporan</div>
                        <a href="{{ route('laporan.penjualan') }}" class="menu-link {{ request()->routeIs('laporan.penjualan') ? 'active' : '' }}" data-label="Laporan Penjualan">
                            <span class="menu-icon"><i data-lucide="line-chart"></i></span>
                            <span class="menu-text">Laporan Penjualan</span>
                        </a>
                        <a href="{{ route('laporan.stok') }}" class="menu-link {{ request()->routeIs('laporan.stok') ? 'active' : '' }}" data-label="Laporan Stok">
                            <span class="menu-icon"><i data-lucide="bar-chart-3"></i></span>
                            <span class="menu-text">Laporan Stok</span>
                        </a>
                        <a href="{{ route('laporan.delivery') }}" class="menu-link {{ request()->routeIs('laporan.delivery') ? 'active' : '' }}" data-label="Laporan Delivery">
                            <span class="menu-icon"><i data-lucide="clipboard-list"></i></span>
                            <span class="menu-text">Laporan Delivery</span>
                        </a>
                    </div>
                @endif
            @endauth
        </div>

        <!-- Sidebar Footer & Profile Dropdown -->
        @auth
            <div class="sidebar-footer">
                <!-- Dropdown Card -->
                <div class="profile-dropdown" id="profileDropdown">
                    <div class="dropdown-item" style="cursor: default; pointer-events: none; border-bottom: 1px solid rgba(139,124,246,0.06); padding-bottom: 8px;">
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-size: 11px; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Login Sebagai</span>
                            <span style="font-weight: 700; font-size: 13.5px; color: var(--text-dark);">{{ auth()->user()->username }}</span>
                        </div>
                    </div>
                    <a href="{{ route('dashboard') }}" class="dropdown-item">
                        <i data-lucide="home" style="width: 16px; height: 16px;"></i>
                        <span>Dashboard</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}" style="width: 100%; margin: 0;">
                        @csrf
                        <button type="submit" class="dropdown-item dropdown-item-danger">
                            <i data-lucide="log-out" style="width: 16px; height: 16px;"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>

                <!-- Footer Profile Trigger Button -->
                <button class="user-profile-trigger" id="profileTriggerBtn" aria-haspopup="true" aria-expanded="false">
                    <div class="user-avatar-wrapper">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                        </div>
                        <div class="user-status-dot"></div>
                    </div>
                    <div class="user-details">
                        <span class="user-name">{{ auth()->user()->username }}</span>
                        <span class="user-role-badge">{{ auth()->user()->role }}</span>
                    </div>
                    <i data-lucide="chevron-up" class="chevron-up-icon" style="width: 18px; height: 18px;"></i>
                </button>
            </div>
        @endauth
    </div>

    <!-- Main Content Wrapper -->
    <div class="content expanded" id="content">
        @yield('content')
    </div>

    <!-- JavaScript for Interactions -->
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const profileTriggerBtn = document.getElementById('profileTriggerBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');

        // Sidebar state persistence
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            content.classList.remove('expanded');
            content.classList.add('collapsed');
            
            // Adjust toggle icon
            const toggleIcon = sidebarToggle.querySelector('i');
            if (toggleIcon) {
                toggleIcon.setAttribute('data-lucide', 'chevron-right');
                lucide.createIcons();
            }
        }

        // Sidebar collapse/expand toggle
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');
            content.classList.toggle('collapsed');

            const collapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', collapsed ? 'true' : 'false');

            // Change chevron direction
            const toggleIcon = sidebarToggle.querySelector('i');
            if (toggleIcon) {
                toggleIcon.setAttribute('data-lucide', collapsed ? 'chevron-right' : 'chevron-left');
                lucide.createIcons();
            }
            
            // Close profile dropdown if sidebar is collapsing
            profileDropdown.classList.remove('show');
        });

        // User profile dropdown toggle
        if (profileTriggerBtn && profileDropdown) {
            profileTriggerBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                profileDropdown.classList.toggle('show');
                
                // Animate chevron
                const chevron = profileTriggerBtn.querySelector('.chevron-up-icon');
                if (chevron) {
                    if (profileDropdown.classList.contains('show')) {
                        chevron.style.transform = 'rotate(180deg)';
                    } else {
                        chevron.style.transform = 'rotate(0deg)';
                    }
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function() {
                profileDropdown.classList.remove('show');
                const chevron = profileTriggerBtn.querySelector('.chevron-up-icon');
                if (chevron) {
                    chevron.style.transform = 'rotate(0deg)';
                }
            });

            // Prevent dropdown closure inside clicking
            profileDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Mobile responsiveness menu drawer toggle
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar.classList.toggle('mobile-show');
            });

            // Tap outside to close drawer on mobile
            document.addEventListener('click', function(e) {
                if (sidebar.classList.contains('mobile-show') && !sidebar.contains(e.target) && e.target !== mobileMenuBtn) {
                    sidebar.classList.remove('mobile-show');
                }
            });
        }
    </script>

</body>
</html>
