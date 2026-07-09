<!--========== HEADER ==========-->
<header class="navbar-fixed-top s-header js__header-sticky">
    <!-- Navbar -->
    <div class="s-header__navbar">
        <div class="s-header__container">
            <div class="s-header__navbar-row">
                <div class="s-header__navbar-row-col" style="width: auto; white-space: nowrap;">
                    <!-- Logo -->
                    <div class="s-header__logo">
                        <a href="{{ route('beranda') }}" class="s-header__logo-link">
                            <img class="object-contain rounded-md s-header__logo-img s-header__logo-img-default" src="{{ asset('images/web-settings/logo.png') }}" alt="Desa Tulungrejo Logo">
                            <img class="object-contain rounded-md s-header__logo-img s-header__logo-img-shrink" src="{{ asset('images/web-settings/logo.png') }}" alt="Desa Tulungrejo Logo">
                        </a>
                    </div>
                    <!-- End Logo -->
                </div>

                <div class="s-header__navbar-list hidden-xs hidden-sm hidden-md" style="width: 100%;">
                    <ul class="list-inline" style="white-space: nowrap;">
                        <li><a href="{{ route('beranda') }}" class="navbar-desktop-link {{ Route::is('beranda') ? 'active-page' : '' }}">BERANDA</a></li>
                        
                        <li class="dropdown-wrapper">
                            <a href="javascript:void(0)" class="navbar-desktop-link">DATA DESA <i class="ti-angle-down" style="font-size: 10px; margin-left: 2px;"></i></a>
                            <ul class="dropdown-menu-custom">
                                <li><a href="#">Profil Desa</a></li>
                                <li><a href="#">SOTK Desa</a></li>
                                <li><a href="#">Visi Misi</a></li>
                                <li><a href="#">Monografi Desa</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-wrapper">
                            <a href="javascript:void(0)" class="navbar-desktop-link">KELEMBAGAAN <i class="ti-angle-down" style="font-size: 10px; margin-left: 2px;"></i></a>
                            <ul class="dropdown-menu-custom">
                                @foreach(\App\Models\Institution::all() as $institution)
                                    <li><a href="#">{{ $institution->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="dropdown-wrapper">
                            <a href="javascript:void(0)" class="navbar-desktop-link">POTENSI DESA <i class="ti-angle-down" style="font-size: 10px; margin-left: 2px;"></i></a>
                            <ul class="dropdown-menu-custom">
                                <li><a href="#">Pariwisata</a></li>
                                <li><a href="#">UMKM</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-wrapper">
                            <a href="javascript:void(0)" class="navbar-desktop-link">INFORMASI <i class="ti-angle-down" style="font-size: 10px; margin-left: 2px;"></i></a>
                            <ul class="dropdown-menu-custom">
                                <li><a href="#">Berita Desa</a></li>
                                <li><a href="#">Agenda Kegiatan</a></li>
                                <li><a href="#">Galeri</a></li>
                                <li><a href="#">Dokumen PPID</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-wrapper">
                            <a href="javascript:void(0)" class="navbar-desktop-link">PELAYANAN <i class="ti-angle-down" style="font-size: 10px; margin-left: 2px;"></i></a>
                            <ul class="dropdown-menu-custom">
                                <li><a href="#">Layanan Surat</a></li>
                                <li><a href="#">Administrasi Online</a></li>
                                <li><a href="#">Tanya Jawab (FAQ)</a></li>
                                <li><a href="#">Kontak Darurat</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="s-header__navbar-row-col hidden-lg">
                    <!-- Trigger -->
                    <a href="javascript:void(0);" class="s-header__trigger" onclick="toggleMobileSidebar()" style="display: flex; align-items: center; justify-content: center;">
                        <i class="ti-menu" style="font-size: 24px; color: #fff;"></i>
                    </a>
                    <!-- End Trigger -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Navbar -->

    <!-- Custom Mobile Sidebar -->
    <div class="custom-mobile-sidebar" id="mobileSidebar">
        <div class="sidebar-header">
            <img class="object-contain" src="{{ asset('images/web-settings/logo.png') }}" alt="Logo" width="120" style="max-height: 50px;">
            <button class="close-sidebar" onclick="toggleMobileSidebar()">&times;</button>
        </div>
        <div class="sidebar-content">
            <ul class="mobile-menu-list">
                <li><a href="{{ route('beranda') }}">BERANDA</a></li>
                
                <li class="has-submenu">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">DATA DESA <i class="ti-angle-down pull-right" style="margin-top: 4px;"></i></a>
                    <ul class="mobile-submenu">
                        <li><a href="#">Profil Desa</a></li>
                        <li><a href="#">SOTK Desa</a></li>
                        <li><a href="#">Visi Misi</a></li>
                        <li><a href="#">Monografi Desa</a></li>
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">KELEMBAGAAN <i class="ti-angle-down pull-right" style="margin-top: 4px;"></i></a>
                    <ul class="mobile-submenu">
                        @foreach(\App\Models\Institution::all() as $institution)
                            <li><a href="#">{{ $institution->name }}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">POTENSI DESA <i class="ti-angle-down pull-right" style="margin-top: 4px;"></i></a>
                    <ul class="mobile-submenu">
                        <li><a href="#">Pariwisata</a></li>
                        <li><a href="#">UMKM</a></li>
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">INFORMASI <i class="ti-angle-down pull-right" style="margin-top: 4px;"></i></a>
                    <ul class="mobile-submenu">
                        <li><a href="#">Berita Desa</a></li>
                        <li><a href="#">Agenda Kegiatan</a></li>
                        <li><a href="#">Galeri</a></li>
                        <li><a href="#">Dokumen PPID</a></li>
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">PELAYANAN <i class="ti-angle-down pull-right" style="margin-top: 4px;"></i></a>
                    <ul class="mobile-submenu">
                        <li><a href="#">Layanan Surat</a></li>
                        <li><a href="#">Administrasi Online</a></li>
                        <li><a href="#">Tanya Jawab (FAQ)</a></li>
                        <li><a href="#">Kontak Darurat</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobileSidebar()"></div>
    <!-- End Custom Mobile Sidebar -->

    <style>
    /* Dropdown Desktop Hover Fix (Optional if needed) */
    .dropdown-wrapper:hover .dropdown-menu-custom {
        display: block;
    }
    .dropdown-menu-custom {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 200px;
        background: #fff;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        padding: 10px 0;
        z-index: 99;
        border-radius: 4px;
        margin: 0;
        list-style: none;
    }
    .dropdown-menu-custom li a {
        display: block;
        padding: 8px 20px;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        text-transform: capitalize;
    }
    .dropdown-menu-custom li a:hover,
    .dropdown-menu-custom li a.active-page {
        background: #f5f5f5;
        color: #dc3545;
    }

    /* Custom Mobile Sidebar Styles */
    .custom-mobile-sidebar {
        position: fixed;
        top: 0;
        left: -320px;
        width: 280px;
        height: 100vh;
        background-color: #fff;
        z-index: 10000;
        transition: left 0.3s ease;
        overflow-y: auto;
        box-shadow: 2px 0 10px rgba(0,0,0,0.2);
    }
    .custom-mobile-sidebar.open {
        left: 0;
    }
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background-color: rgba(0,0,0,0.6);
        z-index: 9999;
        display: none;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .sidebar-overlay.open {
        display: block;
        opacity: 1;
    }
    .sidebar-header {
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f0f0f0;
        background: #fff;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .close-sidebar {
        background: none;
        border: none;
        font-size: 28px;
        cursor: pointer;
        line-height: 1;
        color: #333;
        padding: 0;
    }
    .mobile-menu-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .mobile-menu-list > li {
        border-bottom: 1px solid #f5f5f5;
    }
    .mobile-menu-list > li > a {
        display: block;
        padding: 16px 20px;
        color: #333;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        font-family: inherit;
    }
    .mobile-menu-list > li > a:hover,
    .mobile-menu-list > li > a:focus,
    .mobile-menu-list > li > a.active-page {
        background-color: #fafafa;
        color: #dc3545;
    }
    .mobile-submenu {
        list-style: none;
        padding: 0;
        margin: 0;
        display: none;
        background-color: #fafafa;
        border-top: 1px solid #f5f5f5;
    }
    .mobile-submenu li {
        border-bottom: 1px solid #f0f0f0;
    }
    .mobile-submenu li:last-child {
        border-bottom: none;
    }
    .mobile-submenu li a {
        display: block;
        padding: 12px 20px 12px 40px;
        color: #555;
        text-decoration: none;
        font-size: 14px;
    }
    .mobile-submenu li a:hover,
    .mobile-submenu li a.active-page {
        color: #dc3545;
        background-color: #f0f0f0;
    }
    .mobile-submenu.open {
        display: block;
    }

    /* Shrink state icon color when scrolled */
    .js__header-sticky.s-header--shrink .s-header__trigger i {
        color: #333 !important;
    }
    </style>

    <script>
    function toggleMobileSidebar() {
        var sidebar = document.getElementById('mobileSidebar');
        var overlay = document.getElementById('sidebarOverlay');
        
        if (sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
            setTimeout(() => {
                if(!sidebar.classList.contains('open')) overlay.style.display = 'none';
            }, 300);
        } else {
            overlay.style.display = 'block';
            setTimeout(() => {
                sidebar.classList.add('open');
                overlay.classList.add('open');
            }, 10);
        }
    }

    function toggleSubmenu(element) {
        const submenu = element.nextElementSibling;
        const icon = element.querySelector('i');
        
        if (submenu.classList.contains('open')) {
            submenu.classList.remove('open');
            icon.classList.remove('ti-angle-up');
            icon.classList.add('ti-angle-down');
        } else {
            submenu.classList.add('open');
            icon.classList.remove('ti-angle-down');
            icon.classList.add('ti-angle-up');
        }
    }
    </script>
</header>
<!--========== END HEADER ==========-->