@php
    $webSetting = \App\Models\WebSetting::first();
    $villageName = $webSetting ? $webSetting->village_name : 'Profil Desa';
    $faviconUrl = $webSetting ? $webSetting->favicon_url : asset('favicon.ico');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title', $title ?? 'Dashboard') - Desa {{ $villageName }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ $faviconUrl }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Alpine.js -->
    {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    <!-- Theme Store -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    this.theme = 'light';
                    this.updateTheme();
                },
                theme: 'light',
                toggle() {
                    // Disabled
                },
                updateTheme() {
                    const html = document.documentElement;
                    const body = document.body;
                    html.classList.remove('dark');
                    body.classList.remove('dark', 'bg-gray-900');
                }
            });

            Alpine.store('sidebar', {
                // Initialize based on screen size
                isExpanded: window.innerWidth >= 1280, // true for desktop, false for mobile
                isMobileOpen: false,
                isHovered: false,

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    // When toggling desktop sidebar, ensure mobile menu is closed
                    this.isMobileOpen = false;
                },

                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                    // Don't modify isExpanded when toggling mobile menu
                },

                setMobileOpen(val) {
                    this.isMobileOpen = val;
                },

                setHovered(val) {
                    // Only allow hover effects on desktop when sidebar is collapsed
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;
                    }
                }
            });
        });
    </script>


    @stack('styles')
</head>

<body
    x-data="{ 'loaded': true}"
    x-init="$store.sidebar.isExpanded = window.innerWidth >= 1280;
    const checkMobile = () => {
        if (window.innerWidth < 1280) {
            $store.sidebar.setMobileOpen(false);
            $store.sidebar.isExpanded = false;
        } else {
            $store.sidebar.isMobileOpen = false;
            $store.sidebar.isExpanded = true;
        }
    };
    window.addEventListener('resize', checkMobile);">

    <!-- Enforce light mode immediately to prevent flash -->
    <script>
        (function() {
            document.documentElement.classList.remove('dark');
            if (document.body) {
                document.body.classList.remove('dark', 'bg-gray-900');
            }
        })();
    </script>

    {{-- preloader --}}
    <x-common.preloader/>
    {{-- preloader end --}}

    <div class="min-h-screen xl:flex">
        @include('layouts.backdrop')
        @include('layouts.sidebar')

        <div class="flex-1 transition-all duration-300 ease-in-out"
            :class="{
                'xl:ml-[280px]': $store.sidebar.isExpanded,
                'xl:ml-[76px]': !$store.sidebar.isExpanded,
                'ml-0': $store.sidebar.isMobileOpen
            }">
            <!-- app header start -->
            @include('layouts.app-header')
            <!-- app header end -->
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                @yield('content')
            </div>
        </div>

    </div>

</body>

<!-- Global Modern UI Alert & Confirm Overrides -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Override standard window.alert
        window.alert = function(message) {
            Swal.fire({
                title: 'Informasi',
                text: message,
                icon: 'info',
                confirmButtonColor: '#3b82f6', // blue-500
                confirmButtonText: 'Tutup',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-lg px-4 py-2 font-medium'
                }
            });
        };

        // 2. Intercept forms that use native confirm() in onsubmit
        document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
            // Extract the original message from the onsubmit attribute
            const onsubmitStr = form.getAttribute('onsubmit');
            const match = onsubmitStr.match(/confirm\(\s*['"](.*?)['"]\s*\)/);
            const message = match ? match[1] : 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
            
            // Remove the native onsubmit
            form.removeAttribute('onsubmit');
            
            // Listen for submit with SweetAlert2
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', // red-500
                    cancelButtonColor: '#9ca3af', // gray-400
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-lg px-4 py-2 font-medium',
                        cancelButton: 'rounded-lg px-4 py-2 font-medium mr-3'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@stack('scripts')

</html>
