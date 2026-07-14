<!DOCTYPE html>
<html lang="en" class="no-js">
    <!-- Begin Head -->
    <head>
        <!-- Basic -->
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Desa Tulungrejo</title>
        <meta name="keywords" content="HTML5 Theme" />
        <meta name="description" content="Megakit - HTML5 Theme">
        <meta name="author" content="keenthemes.com">

        <!-- Web Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i|Montserrat:400,700" rel="stylesheet">

        <!-- Vendor Styles -->
        <link href="{{ asset('23/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('23/css/animate.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('23/vendor/themify/themify.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('23/vendor/scrollbar/scrollbar.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('23/vendor/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('23/vendor/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('23/vendor/cubeportfolio/css/cubeportfolio.min.css') }}" rel="stylesheet" type="text/css"/>

        <!-- Theme Styles -->
        <link href="{{ asset('23/css/style.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('23/css/global/global.css') }}" rel="stylesheet" type="text/css"/>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('images/web-settings/icon-tab.png') }}" type="image/x-icon">
        <link rel="apple-touch-icon" href="{{ asset('images/web-settings/icon-tab.png') }}">
        <!-- Custom Global Overrides -->
        <style>
            @media (min-width: 1200px) {
                .container {
                    width: 95% !important;
                    max-width: 1600px !important;
                }
            }
        </style>
    </head>
    <!-- End Head -->
    <body>

        {{-- Navigation --}}
        @include('user.components.navbar')

        <main>
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('user.components.footer')

        <script type="text/javascript" src="{{ asset('23/vendor/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('23/vendor/jquery.migrate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('23/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('23/vendor/jquery.smooth-scroll.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('23/vendor/jquery.back-to-top.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('23/vendor/scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('23/vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('23/vendor/swiper/swiper.jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('23/vendor/jquery.wow.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('23/js/global.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('23/js/components/magnific-popup.min.js') }}"></script>
        {{-- Floating WhatsApp --}}
        @php
            if(!isset($setting)) {
                $setting = \App\Models\WebSetting::first();
            }
            // Ambil nomor administrasi (bisa WA) dari contact_services, bukan nomor telepon kabel desa
            $contactServicePhone = \App\Models\ContactService::where('is_active', true)
                ->whereNotNull('phone')
                ->orderBy('order_num')
                ->value('phone');
        @endphp
        @include('user.components.floating-wa', ['contactServicePhone' => $contactServicePhone])

        <script type="text/javascript" src="{{ asset('23/js/components/header-sticky.min.js') }}"></script>
        <script src="{{ asset('23/js/components/navbar-mobile.js') }}"></script>

        @yield('scripts')
    </body>
</html>