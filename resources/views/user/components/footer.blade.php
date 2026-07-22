@php
    $setting = \App\Models\WebSetting::first();
@endphp
<!--========== FOOTER ==========-->
<footer class="g-bg-color--dark">
    <!-- Links -->
    <div class="g-hor-divider__dashed--white-opacity-lightest">
        <div class="container g-padding-y-50--xs">
            <div class="row">
                
                <!-- Column 1: Info & Logo -->
                <div class="col-md-4 col-sm-12 g-margin-b-40--xs g-margin-b-0--md s-footer__logo">
                    <img class="g-width-100--xs g-height-auto--xs g-margin-b-20--xs" src="{{ asset('images/web-settings/logo.png') }}" alt="Logo Desa" style="max-width: 150px; object-fit: contain;">
                    <h3 class="g-font-size-18--xs g-color--white">{{ 'DESA ' . ($setting->village_name ?? 'Desa Tulungrejo') }}</h3>
                    <p class="g-color--white-opacity">
                        {{ $setting->address ?? 'Alamat lengkap desa belum diatur.' }}
                    </p>
                    @if($setting && $setting->phone)
                        <p class="g-color--white-opacity g-margin-b-0--xs"><i class="ti-headphone-alt g-margin-r-5--xs"></i> {{ $setting->phone }}</p>
                    @endif
                    @if($setting && $setting->email)
                        <p class="g-color--white-opacity"><i class="ti-email g-margin-r-5--xs"></i> {{ $setting->email }}</p>
                    @endif
                </div>

                <!-- Column 2: Navigation -->
                <div class="col-md-2 col-sm-6 g-margin-b-40--xs g-margin-b-0--md">
                    <h4 class="g-font-size-16--xs g-color--white g-margin-b-20--xs">Navigasi</h4>
                    <ul class="list-unstyled g-ul-li-tb-5--xs g-margin-b-0--xs">
                        <li><a class="g-font-size-15--xs g-color--white-opacity hover:g-color--primary" href="{{ route('beranda') }}">Beranda</a></li>
                        <li><a class="g-font-size-15--xs g-color--white-opacity hover:g-color--primary" href="{{ route('berita-desa') }}">Berita Desa</a></li>
                        <li><a class="g-font-size-15--xs g-color--white-opacity hover:g-color--primary" href="{{ route('galeri') }}">Galeri</a></li>
                        <li><a class="g-font-size-15--xs g-color--white-opacity hover:g-color--primary" href="{{ route('kontak-darurat') }}">Kontak Darurat</a></li>
                    </ul>
                </div>

                <!-- Column 3: Social Media -->
                <div class="col-md-3 col-sm-6 g-margin-b-40--xs g-margin-b-0--md">
                    <h4 class="g-font-size-16--xs g-color--white g-margin-b-20--xs">Sosial Media</h4>
                    <ul class="list-inline g-ul-li-tb-5--xs g-margin-b-0--xs">
                        @if($setting && $setting->facebook)
                            <li><a class="g-color--white-opacity g-font-size-20--xs g-margin-r-10--xs hover:g-color--primary" href="{{ $setting->facebook }}" target="_blank"><i class="ti-facebook"></i></a></li>
                        @endif
                        @if($setting && $setting->instagram)
                            <li><a class="g-color--white-opacity g-font-size-20--xs g-margin-r-10--xs hover:g-color--primary" href="{{ $setting->instagram }}" target="_blank"><i class="ti-instagram"></i></a></li>
                        @endif
                        @if($setting && $setting->twitter)
                            <li><a class="g-color--white-opacity g-font-size-20--xs g-margin-r-10--xs hover:g-color--primary" href="{{ $setting->twitter }}" target="_blank"><i class="ti-twitter"></i></a></li>
                        @endif
                        @if($setting && $setting->youtube)
                            <li><a class="g-color--white-opacity g-font-size-20--xs g-margin-r-10--xs hover:g-color--primary" href="{{ $setting->youtube }}" target="_blank"><i class="ti-youtube"></i></a></li>
                        @endif
                        @if($setting && $setting->linktree)
                            <li>
                                <a class="g-color--white-opacity g-margin-r-10--xs hover:g-color--primary" href="{{ $setting->linktree }}" target="_blank" title="Linktree" style="display:inline-flex; align-items:center; text-decoration:none;">
                                    <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" style="vertical-align:middle;">
                                        <path d="m13.73635 5.85251 4.00467-4.11665 2.3248 2.3808-4.20064 4.00466h5.9085v3.30473h-5.9365l4.22865 4.10766-2.3248 2.3338L12.0005 12.099l-5.74052 5.76852-2.3248-2.3248 4.22864-4.10766h-5.9375V8.12132h5.9085L3.93417 4.11666l2.3248-2.3808 4.00468 4.11665V0h3.4727zm-3.4727 10.30614h3.4727V24h-3.4727z"/>
                                    </svg>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

                <!-- Column 4: Credit KKN -->
                <div class="col-md-3 col-sm-6 g-margin-b-40--xs g-margin-b-0--md">
                    <!-- <h4 class="g-font-size-16--xs g-color--white g-margin-b-20--xs">Dikembangkan Oleh</h4> -->
                    <div class="g-margin-b-15--xs">
                        <img src="{{ asset('images/logoum.png') }}" alt="Logo UM" style="max-width: 60px; height: auto; margin-right: 10px;">
                        <img src="{{ asset('images/logoumbbm.png') }}" alt="Logo UM BBM" style="max-width: 60px; height: auto;">
                    </div>
                    <p class="g-font-size-14--xs g-color--white-opacity g-margin-b-10--xs" style="line-height: 1.6;">
                        Dikembangkan Oleh <br>
                        <b>Tim UM BBM Tematik Universitas Negeri Malang 2026</b>
                    </p>
                    <a href="https://www.instagram.com/umbbm.desatulungrejo?" target="_blank" class="g-color--white-opacity hover:g-color--primary" style="display: inline-flex; align-items: center; text-decoration: none;">
                        <i class="ti-instagram g-font-size-18--xs g-margin-r-5--xs"></i> @umbbm.desatulungrejo
                    </a>
                </div>

            </div>
        </div>
    </div>
    <!-- End Links -->

    <!-- Copyright -->
    <div class="container g-padding-y-20--xs">
        <div class="row">
            <div class="col-xs-12 g-text-center--xs">
                <p class="g-font-size-14--xs g-margin-b-0--xs g-color--white-opacity-light">&copy; {{ date('Y') }} Pemerintah Desa {{ $setting->village_name ?? 'Tulungrejo' }}. Dikembangkan oleh Tim UM BBM Tematik Universitas Negeri Malang 2026.</p>
            </div>
        </div>
    </div>
    <!-- End Copyright -->
</footer>
<!--========== END FOOTER ==========-->