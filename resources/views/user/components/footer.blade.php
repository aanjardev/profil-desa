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
                <div class="col-md-5 col-sm-12 g-margin-b-40--xs g-margin-b-0--md s-footer__logo">
                    <img class="g-width-100--xs g-height-auto--xs g-margin-b-20--xs" src="{{ asset('images/web-settings/logo.png') }}" alt="Logo Desa" style="max-width: 150px; object-fit: contain;">
                    <h3 class="g-font-size-18--xs g-color--white">{{ 'DESA ' . $setting->village_name ?? 'Desa Tulungrejo' }}</h3>
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
                <div class="col-md-3 col-sm-6 g-margin-b-40--xs g-margin-b-0--md">
                    <h4 class="g-font-size-16--xs g-color--white g-margin-b-20--xs">Navigasi</h4>
                    <ul class="list-unstyled g-ul-li-tb-5--xs g-margin-b-0--xs">
                        <li><a class="g-font-size-15--xs g-color--white-opacity hover:g-color--primary" href="{{ route('beranda') }}">Beranda</a></li>
                        <li><a class="g-font-size-15--xs g-color--white-opacity hover:g-color--primary" href="javascript:void(0);">Berita Desa</a></li>
                        <li><a class="g-font-size-15--xs g-color--white-opacity hover:g-color--primary" href="javascript:void(0);">Galeri</a></li>
                        <li><a class="g-font-size-15--xs g-color--white-opacity hover:g-color--primary" href="javascript:void(0);">Kontak Darurat</a></li>
                    </ul>
                </div>

                <!-- Column 3: Social Media -->
                <div class="col-md-4 col-sm-6 g-margin-b-40--xs g-margin-b-0--md">
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
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <!-- End Links -->

    <!-- Copyright -->
    <div class="container g-padding-y-20--xs">
        <div class="row">
            <div class="col-xs-12 g-text-center--xs">
                <p class="g-font-size-14--xs g-margin-b-0--xs g-color--white-opacity-light">&copy; {{ date('Y') }} Pemerintah Desa {{ $setting->village_name ?? 'Desa' }}. All Rights Reserved.</p>
            </div>
        </div>
    </div>
    <!-- End Copyright -->
</footer>
<!--========== END FOOTER ==========-->