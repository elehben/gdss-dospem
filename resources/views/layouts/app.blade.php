<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GDSS - WP & Borda</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- Custom CSS Files --}}
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    <!-- <link rel="icon" type="image/x-icon" href="/images/favicon.ico"> -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/download.svg') }}">

    {{-- Additional Styles from Child Views --}}
    @stack('styles')
</head>
<body>

    {{-- SIDEBAR OVERLAY (Mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">
        {{-- Sidebar Header --}}
        <div class="sidebar-header">
            <div class="sidebar-logo" id="sidebarToggleLogo" title="Toggle Sidebar">
                <i class="bi bi-exclude"></i>
            </div>
            <div class="sidebar-brand">
                <span class="sidebar-brand-title">GDSS</span>
                <span class="sidebar-brand-subtitle">Decision Support</span>
            </div>
            <button class="btn-close-sidebar" id="closeSidebar">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        {{-- Sidebar Menu --}}
        <div class="sidebar-menu">
            <div class="menu-label">Menu Utama</div>
            
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <div class="menu-icon" data-title="Dashboard">
                    <i class="bi bi-grid-1x2-fill"></i>
                </div>
                <span class="menu-text">Dashboard</span>
            </a>

            <div class="menu-label">Master Data</div>

            <a href="{{ route('kriteria.index') }}" class="menu-item {{ request()->routeIs('kriteria.*') ? 'active' : '' }}">
                <div class="menu-icon" data-title="Kriteria">
                    <i class="bi bi-sliders"></i>
                </div>
                <span class="menu-text">Kriteria</span>
            </a>

            <a href="{{ route('alternatif.index') }}" class="menu-item {{ request()->routeIs('alternatif.*') ? 'active' : '' }}">
                <div class="menu-icon" data-title="Alternatif">
                    <i class="bi bi-people-fill"></i>
                </div>
                <span class="menu-text">Alternatif</span>
            </a>

            {{-- Menu Khusus USER (Decision Maker) --}}
            @if(auth()->check() && !auth()->user()->isAdmin())
                <div class="menu-label">Penilaian</div>

                <a href="{{ route('penilaian.index') }}" class="menu-item {{ request()->routeIs('penilaian.*') ? 'active' : '' }}">
                    <div class="menu-icon" data-title="Input Penilaian">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <span class="menu-text">Input Penilaian</span>
                </a>

                <a href="{{ route('hasil.wp') }}" class="menu-item {{ request()->routeIs('hasil.wp') ? 'active' : '' }}">
                    <div class="menu-icon" data-title="Hasil WP">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <span class="menu-text">Hasil WP</span>
                </a>
            @endif

            {{-- Menu Khusus ADMIN --}}
            @if(auth()->check() && auth()->user()->isAdmin())
                @php
                    $decisionMakers = \App\Models\User::where('id_user', '!=', 'U0001')->orderBy('name')->get();
                @endphp
                
                <div class="menu-label">Decision Makers</div>
                
                <div class="menu-dropdown">
                    <button class="menu-dropdown-toggle {{ request()->routeIs('hasil.wp.dm') ? 'active' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#dmSubmenu" aria-expanded="{{ request()->routeIs('hasil.wp.dm') ? 'true' : 'false' }}">
                        <div class="menu-icon" data-title="Hasil WP DM">
                            <i class="bi bi-person-lines-fill"></i>
                        </div>
                        <span class="menu-text">Hasil WP DM</span>
                        <i class="bi bi-chevron-down dropdown-arrow"></i>
                    </button>
                    <div class="collapse submenu {{ request()->routeIs('hasil.wp.dm') ? 'show' : '' }}" id="dmSubmenu">
                        @foreach($decisionMakers as $dm)
                            <a href="{{ route('hasil.wp.dm', $dm->id_user) }}" class="menu-item {{ request()->route('userId') == $dm->id_user ? 'active' : '' }}">
                                <div class="menu-icon" data-title="{{ $dm->name }}">
                                    <i class="bi bi-person"></i>
                                </div>
                                <span class="menu-text">{{ $dm->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="menu-label">Hasil Akhir</div>

                <a href="{{ route('hasil.borda') }}" class="menu-item {{ request()->routeIs('hasil.borda') ? 'active' : '' }}">
                    <div class="menu-icon" data-title="Hasil Borda">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <span class="menu-text">Hasil Borda</span>
                </a>
            @endif
        </div>

        {{-- Sidebar Footer --}}
        @auth
        <div class="sidebar-footer">
            <div class="user-card">
                <a href="{{ route('profile') }}" class="user-avatar" title="Lihat Profil" data-title="{{ auth()->user()->name }}">
                    <i class="bi bi-person-fill"></i>
                </a>
                <div class="user-info">
                    <a href="{{ route('profile') }}" class="user-name">{{ auth()->user()->name }}</a>
                    <div class="user-role">
                        @if(auth()->user()->isAdmin())
                            <span class="badge bg-warning text-dark">Administrator</span>
                        @else
                            <span class="badge bg-info">Decision Maker</span>
                        @endif
                    </div>
                </div>
                <button type="button" class="btn-logout" title="Logout" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </div>
        </div>
        @endauth
    </aside>

    {{-- MAIN WRAPPER --}}
    <div class="main-wrapper">
        {{-- Topbar --}}
        <header class="topbar">
            <div class="topbar-left">
                <button class="btn-toggle-sidebar" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <div class="page-info">
                    <h4>
                        @if(request()->routeIs('dashboard'))
                            Dashboard
                        @elseif(request()->routeIs('kriteria.*'))
                            Kriteria
                        @elseif(request()->routeIs('alternatif.*'))
                            Alternatif
                        @elseif(request()->routeIs('penilaian.*'))
                            Input Penilaian
                        @elseif(request()->routeIs('hasil.wp'))
                            Hasil WP
                        @elseif(request()->routeIs('hasil.borda'))
                            Hasil Akhir Borda
                        @elseif(request()->routeIs('hasil.wp.dm'))
                            Hasil WP Decision Maker
                        @elseif(request()->routeIs('profile'))
                            Profil Saya
                        @else
                            GDSS App
                        @endif
                    </h4>
                    <p>Sistem Pendukung Keputusan Kelompok</p>
                </div>
            </div>
            <div class="topbar-right">
                <div class="topbar-date">
                    <i class="bi bi-calendar3"></i>
                    <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="main-content">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="main-footer">
            <i class="bi bi-exclude me-2"></i>
            <span>&copy; {{ date('Y') }} <strong>GDSS APP</strong> - Sistem Pendukung Keputusan Kelompok | Metode WP & Borda</span>
        </footer>
    </div>

    {{-- Logout Confirmation Modal --}}
    @auth
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 30px; overflow: hidden;">
                <div class="modal-header border-0" style="background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%); padding: 1.5rem;">
                    <h5 class="modal-title text-white" id="logoutModalLabel">
                        <i class="bi bi-box-arrow-right me-2"></i>Konfirmasi Logout
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="padding: 2rem;">
                    <div style="width: 80px; height: 80px; border-radius: 30%; background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <i class="bi bi-question-lg text-white" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 style="font-weight: 700; color: #1a1a2e; margin-bottom: 0.5rem;">Yakin ingin keluar?</h5>
                    <p style="color: #6c757d; margin-bottom: 0;">Anda akan keluar dari sistem dan perlu login kembali untuk mengakses aplikasi.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center" style="padding: 0 2rem 2rem; gap: 1rem;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="padding: 0.75rem 2rem; border-radius: 10px; font-weight: 600; background: #f1f3f4; color: #5f6368; border: none;">
                        <i class="bi bi-x-lg me-2"></i>Batal
                    </button>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn" style="padding: 0.75rem 2rem; border-radius: 10px; font-weight: 600; background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%); color: white; border: none;">
                            <i class="bi bi-box-arrow-right me-2"></i>Ya, Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endauth

    {{-- Bootstrap JS Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Sidebar Toggle Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleBtn = document.getElementById('toggleSidebar');
            const closeBtn = document.getElementById('closeSidebar');
            const logoToggle = document.getElementById('sidebarToggleLogo');
            const mainWrapper = document.querySelector('.main-wrapper');

            // Restore collapsed state from localStorage
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed && window.innerWidth >= 992) {
                sidebar.classList.add('collapsed');
                mainWrapper.classList.add('expanded');
            }

            function openSidebar() {
                sidebar.classList.add('show');
                overlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }

            // Collapse toggle function (for desktop)
            function toggleCollapse() {
                sidebar.classList.toggle('collapsed');
                mainWrapper.classList.toggle('expanded');
                
                // Save state to localStorage
                const collapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', collapsed);
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (sidebar.classList.contains('show')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    closeSidebar();
                });
            }

            // Logo click to toggle collapse (desktop only)
            if (logoToggle) {
                logoToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (window.innerWidth >= 992) {
                        toggleCollapse();
                    }
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    closeSidebar();
                });
            }

            // Close sidebar when clicking menu item on mobile
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        closeSidebar();
                    }
                });
            });

            // Reset collapsed state on mobile
            window.addEventListener('resize', function() {
                if (window.innerWidth < 992) {
                    sidebar.classList.remove('collapsed');
                    mainWrapper.classList.remove('expanded');
                } else if (localStorage.getItem('sidebarCollapsed') === 'true') {
                    sidebar.classList.add('collapsed');
                    mainWrapper.classList.add('expanded');
                }
            });
        });
    </script>

    {{-- Script Tambahan (jika ada di view anak) --}}
    @stack('scripts')
</body>
</html>