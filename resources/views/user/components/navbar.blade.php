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
                                <li><a href="{{ route('profil-desa') }}">Profil Desa</a></li>
                                <li><a href="{{ route('sotk-desa') }}">SOTK Desa</a></li>
                                <li><a href="{{ route('visi-misi') }}">Visi Misi</a></li>
                                <li><a href="{{ route('monografi-desa') }}">Monografi Desa</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-wrapper">
                            <a href="javascript:void(0)" class="navbar-desktop-link">KELEMBAGAAN <i class="ti-angle-down" style="font-size: 10px; margin-left: 2px;"></i></a>
                            <ul class="dropdown-menu-custom">
                                @foreach(\App\Models\Institution::all() as $institution)
                                    <li><a href="{{ route('kelembagaan.show', $institution->id) }}">{{ $institution->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="dropdown-wrapper">
                            <a href="javascript:void(0)" class="navbar-desktop-link">POTENSI DESA <i class="ti-angle-down" style="font-size: 10px; margin-left: 2px;"></i></a>
                            <ul class="dropdown-menu-custom">
                                <li><a href="{{ route('pariwisata') }}">Pariwisata</a></li>
                                <li><a href="{{ route('umkm') }}">UMKM</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-wrapper">
                            <a href="javascript:void(0)" class="navbar-desktop-link">INFORMASI <i class="ti-angle-down" style="font-size: 10px; margin-left: 2px;"></i></a>
                            <ul class="dropdown-menu-custom">
                                <li><a href="{{ route('berita-desa') }}">Berita Desa</a></li>
                                <li><a href="{{ route('agenda-kegiatan') }}">Agenda Kegiatan</a></li>
                                <li><a href="{{ route('galeri') }}">Galeri</a></li>
                                <li><a href="{{ route('dokumen-ppid') }}">Dokumen PPID</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-wrapper">
                            <a href="javascript:void(0)" class="navbar-desktop-link">PELAYANAN <i class="ti-angle-down" style="font-size: 10px; margin-left: 2px;"></i></a>
                            <ul class="dropdown-menu-custom">
                                <li><a href="{{ route('layanan-surat') }}">Layanan Surat</a></li>
                                <li><a href="{{ route('administrasi-online') }}">Administrasi Online</a></li>
                                <li><a href="{{ route('faq') }}">Tanya Jawab (FAQ)</a></li>
                                <li><a href="{{ route('kontak-darurat') }}">Kontak Darurat</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="s-header__navbar-row-col hidden-lg">
                    <!-- Trigger -->
                    <a href="javascript:void(0);" class="s-header__trigger" onclick="toggleMobileSidebar()" style="display: flex; align-items: center; justify-content: center;">
                        <i class="ti-menu" style="font-size: 24px;"></i>
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
                        <li><a href="{{ route('profil-desa') }}">Profil Desa</a></li>
                        <li><a href="{{ route('sotk-desa') }}">SOTK Desa</a></li>
                        <li><a href="{{ route('visi-misi') }}">Visi Misi</a></li>
                        <li><a href="{{ route('monografi-desa') }}">Monografi Desa</a></li>
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">KELEMBAGAAN <i class="ti-angle-down pull-right" style="margin-top: 4px;"></i></a>
                    <ul class="mobile-submenu">
                        @foreach(\App\Models\Institution::all() as $institution)
                            <li><a href="{{ route('kelembagaan.show', $institution->id) }}">{{ $institution->name }}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">POTENSI DESA <i class="ti-angle-down pull-right" style="margin-top: 4px;"></i></a>
                    <ul class="mobile-submenu">
                        <li><a href="{{ route('pariwisata') }}">Pariwisata</a></li>
                        <li><a href="{{ route('umkm') }}">UMKM</a></li>
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">INFORMASI <i class="ti-angle-down pull-right" style="margin-top: 4px;"></i></a>
                    <ul class="mobile-submenu">
                        <li><a href="{{ route('berita-desa') }}">Berita Desa</a></li>
                        <li><a href="{{ route('agenda-kegiatan') }}">Agenda Kegiatan</a></li>
                        <li><a href="{{ route('galeri') }}">Galeri</a></li>
                        <li><a href="{{ route('dokumen-ppid') }}">Dokumen PPID</a></li>
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">PELAYANAN <i class="ti-angle-down pull-right" style="margin-top: 4px;"></i></a>
                    <ul class="mobile-submenu">
                        <li><a href="{{ route('layanan-surat') }}">Layanan Surat</a></li>
                        <li><a href="{{ route('administrasi-online') }}">Administrasi Online</a></li>
                        <li><a href="{{ route('faq') }}">Tanya Jawab (FAQ)</a></li>
                        <li><a href="{{ route('kontak-darurat') }}">Kontak Darurat</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobileSidebar()"></div>
    <!-- End Custom Mobile Sidebar -->
</header>
<!--========== END HEADER ==========-->