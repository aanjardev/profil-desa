<!--========== HEADER ==========-->
<header class="navbar-fixed-top s-header js__header-sticky js__header-overlay">
    <!-- Navbar -->
    <div class="s-header__navbar">
        <div class="s-header__container">
            <div class="s-header__navbar-row">
                <div class="s-header__navbar-row-col">
                    <!-- Logo -->
                    <div class="s-header__logo">
                        <a href="{{ route('beranda') }}" class="s-header__logo-link">
                            <img class="object-contain rounded-md s-header__logo-img s-header__logo-img-default" src="{{ asset('images/web-settings/logo.png') }}" alt="Desa Tulungrejo Logo">
                            <img class="object-contain rounded-md s-header__logo-img s-header__logo-img-shrink" src="{{ asset('images/web-settings/logo.png') }}" alt="Desa Tulungrejo Logo">
                        </a>
                    </div>
                    <!-- End Logo -->
                </div>
                <div class="s-header__navbar-row-col">
                    <!-- Trigger -->
                    <a href="javascript:void(0);" class="s-header__trigger js__trigger">
                        <span class="s-header__trigger-icon"></span>
                        <svg x="0rem" y="0rem" width="3.125rem" height="3.125rem" viewbox="0 0 54 54">
                            <circle fill="transparent" stroke="#fff" stroke-width="1" cx="27" cy="27" r="25" stroke-dasharray="157 157" stroke-dashoffset="157"></circle>
                        </svg>
                    </a>
                    <!-- End Trigger -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Navbar -->

    <!-- Overlay -->
    <div class="s-header-bg-overlay js__bg-overlay">
        <!-- Nav -->
        <nav class="s-header__nav js__scrollbar">
            <div class="container-fluid">
                <!-- Menu List -->                                
                <ul class="list-unstyled s-header__nav-menu">
                    <li class="s-header__nav-menu-item"><a class="s-header__nav-menu-link s-header__nav-menu-link-divider {{ Route::is('beranda') ? ' -is-active' : '' }}" href="{{ route('beranda') }}">Beranda</a></li>
                    <li class="s-header__nav-menu-item"><a class="s-header__nav-menu-link s-header__nav-menu-link-divider {{ Route::is('index-app-landing') ? ' -is-active' : '' }}" href="{{ route('index-app-landing') }}">App Landing</a></li>
                    <li class="s-header__nav-menu-item"><a class="s-header__nav-menu-link s-header__nav-menu-link-divider {{ Route::is('index-portfolio') ? ' -is-active' : '' }}" href="{{ route('index-portfolio') }}">Portfolio</a></li>
                    <li class="s-header__nav-menu-item"><a class="s-header__nav-menu-link s-header__nav-menu-link-divider {{ Route::is('index-lawyer') ? ' -is-active' : '' }}" href="{{ route('index-lawyer') }}">Lawyer</a></li>
                    <li class="s-header__nav-menu-item"><a class="s-header__nav-menu-link s-header__nav-menu-link-divider" href="#">Clinic</a></li>
                    <li class="s-header__nav-menu-item"><a class="s-header__nav-menu-link s-header__nav-menu-link-divider {{ Route::is('index-coming-soon') ? ' -is-active' : '' }}" href="{{ route('index-coming-soon') }}">Coming Soon</a></li>
                </ul>
                <!-- End Menu List -->

                <!-- Menu List -->                                
                <ul class="list-unstyled s-header__nav-menu">
                    <li class="s-header__nav-menu-item"><a class="s-header__nav-menu-link s-header__nav-menu-link-divider {{ Route::is('about') ? ' -is-active' : '' }}" href="{{ route('about') }}">About</a></li>
                    <li class="s-header__nav-menu-item"><a class="s-header__nav-menu-link s-header__nav-menu-link-divider {{ Route::is('kelembagaan') ? ' -is-active' : '' }}" href="{{ route('kelembagaan') }}">Kelembagaan</a></li>
                    <li class="s-header__nav-menu-item"><a class="s-header__nav-menu-link s-header__nav-menu-link-divider {{ Route::is('services') ? ' -is-active' : '' }}" href="{{ route('services') }}">Services</a></li>
                    <li class="s-header__nav-menu-item"><a class="s-header__nav-menu-link s-header__nav-menu-link-divider {{ Route::is('events') ? ' -is-active' : '' }}" href="{{ route('events') }}">Events</a></li>
                    <li class="s-header__nav-menu-item"><a class="s-header__nav-menu-link s-header__nav-menu-link-divider {{ Route::is('faq') ? ' -is-active' : '' }}" href="{{ route('faq') }}">FAQ</a></li>
                    <li class="s-header__nav-menu-item"><a class="s-header__nav-menu-link s-header__nav-menu-link-divider {{ Route::is('contacts') ? ' -is-active' : '' }}" href="{{ route('contacts') }}">Contacts</a></li>
                </ul>
                <!-- End Menu List -->
            </div>
        </nav>
        <!-- End Nav -->
                
        <!-- Action -->
        <ul class="list-inline s-header__action s-header__action--lb">
            <li class="s-header__action-item"><a class="s-header__action-link -is-active" href="#">En</a></li>
            <li class="s-header__action-item"><a class="s-header__action-link" href="#">Fr</a></li>
        </ul>
        <!-- End Action -->

        <!-- Action -->
        <ul class="list-inline s-header__action s-header__action--rb">
            <li class="s-header__action-item">
                <a class="s-header__action-link" href="#">
                    <i class="g-padding-r-5--xs ti-facebook"></i>
                    <span class="g-display-none--xs g-display-inline-block--sm">Facebook</span>
                </a>
            </li>
            <li class="s-header__action-item">
                <a class="s-header__action-link" href="#">
                    <i class="g-padding-r-5--xs ti-twitter"></i>
                    <span class="g-display-none--xs g-display-inline-block--sm">Twitter</span>
                </a>
            </li>
            <li class="s-header__action-item">
                <a class="s-header__action-link" href="#">
                    <i class="g-padding-r-5--xs ti-instagram"></i>
                    <span class="g-display-none--xs g-display-inline-block--sm">Instagram</span>
                </a>
            </li>
        </ul>
        <!-- End Action -->
    </div>
    <!-- End Overlay -->
</header>
 <!--========== END HEADER ==========-->