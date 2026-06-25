@php
    $webSetting   = \App\Models\WebSetting::first();
    $villageName  = $webSetting ? $webSetting->village_name : 'Profil Desa';
    $faviconUrl   = $webSetting ? $webSetting->favicon_url   : asset('favicon.ico');
    $logoUrl      = $webSetting ? $webSetting->logo_url      : asset('images/logo/logo.svg');
    // Favicon / icon tab URL (logo kota)
    $iconTabUrl   = $webSetting && $webSetting->favicon_path
        ? (str_starts_with($webSetting->favicon_path, 'images/') ? asset($webSetting->favicon_path) : asset('storage/' . $webSetting->favicon_path))
        : asset('favicon.ico');
    // Data lokasi
    $city         = $webSetting ? $webSetting->city       : null;
    $province     = $webSetting ? $webSetting->province   : null;
    $address      = $webSetting ? $webSetting->address    : null;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - {{ $villageName }}</title>
    <meta name="description" content="Halaman masuk admin Desa {{ $villageName }}">
    <link rel="icon" href="{{ $faviconUrl }}">
    @vite(['resources/css/app.css'])

    <style>
        /* ===== AUTH LAYOUT ===== */
        .auth-wrapper {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background-color: #f8fafc;
        }

        /* ===== LEFT PANEL (HERO) ===== */
        .auth-hero {
            position: relative;
            background-color: #0f172a;
            display: block;
            overflow: hidden;
        }

        /* Background image layer */
        .auth-hero-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            z-index: 1;
            display: block;
        }

        /* Dark overlay on top of image */
        .auth-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                160deg,
                rgba(15, 23, 42, 0.72) 0%,
                rgba(29, 78, 216, 0.60) 50%,
                rgba(49, 46, 129, 0.75) 100%
            );
            z-index: 2;
        }

        .auth-hero-pattern {
            position: absolute;
            inset: 0;
            z-index: 3;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Placeholder shown when no image set */
        .auth-hero-bg-placeholder {
            position: absolute;
            inset: 0;
            z-index: 0;
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 40%, #312e81 100%);
        }

        .auth-hero-content {
            position: absolute;
            inset: 0;
            z-index: 4;
            display: flex;
            flex-direction: column;
            /* Logo di pojok kiri atas, teks tengah bawah */
        }

        /* Logo pojok kiri atas */
        .auth-hero-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 2rem 2.25rem;
        }

        /* Logo desa (kiri) */
        .auth-hero-logo-main {
            height: 52px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.4)) brightness(0) invert(1);
            flex-shrink: 0;
        }

        /* Separator */
        .auth-hero-logo-sep {
            width: 1px;
            height: 36px;
            background: rgba(255,255,255,0.3);
            flex-shrink: 0;
        }

        /* Icon tab / logo kota (kanan) */
        .auth-hero-logo-icon {
            height: 44px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 6px rgba(0,0,0,0.35));
            flex-shrink: 0;
        }

        .auth-hero-logo-name {
            font-size: 1.5rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            text-shadow: 0 2px 8px rgba(0,0,0,0.6);
            letter-spacing: 0.02em;
        }

        .auth-hero-logo-sub {
            font-size: 1rem;
            color: rgba(255,255,255,0.9);
            font-weight: 600;
            text-shadow: 0 1px 4px rgba(0,0,0,0.6);
            margin-top: 0.125rem;
        }

        /* Teks judul di tengah-bawah panel */
        .auth-hero-bottom {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-end;
            padding: 0 2.5rem 2.75rem;
        }

        .auth-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 9999px;
            padding: 0.375rem 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255,255,255,0.9);
            margin-bottom: 2rem;
        }

        .auth-hero-title {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1.1;
            margin: 0 0 1rem;
            text-shadow: 0 4px 24px rgba(0,0,0,0.6);
            color: #fff;
            text-align: left;
            letter-spacing: -0.02em;
        }

        .auth-hero-title span {
            color: #93c5fd;
        }

        .auth-hero-desc {
            font-size: 1.125rem;
            color: rgba(255,255,255,0.95);
            font-weight: 500;
            line-height: 1.6;
            margin: 0 0 2rem;
            text-align: left;
            text-shadow: 0 2px 8px rgba(0,0,0,0.6);
        }

        /* Info lokasi desa di bawah deskripsi */
        .auth-hero-location {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .auth-hero-location-row {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .auth-hero-location-row svg {
            flex-shrink: 0;
            margin-top: 3px;
            color: rgba(255,255,255,0.9);
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.6));
        }

        .auth-hero-location-text {
            font-size: 1rem;
            color: rgba(255,255,255,0.95);
            font-weight: 600;
            line-height: 1.5;
            text-shadow: 0 2px 8px rgba(0,0,0,0.6);
        }

        .auth-hero-location-text strong {
            color: #ffffff;
            font-weight: 800;
        }

        .auth-hero-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 1rem;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.875rem;
        }

        .auth-hero-feature {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-align: left;
        }

        .auth-hero-feature-icon {
            width: 2rem;
            height: 2rem;
            background: rgba(255,255,255,0.15);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .auth-hero-feature-text {
            font-size: 0.875rem;
            color: rgba(255,255,255,0.85);
            font-weight: 500;
        }

        .auth-hero-deco {
            position: absolute;
            border-radius: 9999px;
            background: rgba(255,255,255,0.06);
        }

        .auth-hero-deco-1 {
            width: 300px; height: 300px;
            top: -100px; right: -100px;
        }

        .auth-hero-deco-2 {
            width: 200px; height: 200px;
            bottom: -60px; left: -60px;
        }

        /* ===== RIGHT PANEL (FORM) ===== */
        .auth-form-panel {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
            background: #ffffff;
            overflow-y: auto;
        }

        .auth-form-inner {
            width: 100%;
            max-width: 420px;
        }

        /* Logo Area */
        .auth-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .auth-logo img {
            height: 44px;
            width: auto;
            object-fit: contain;
        }

        .auth-logo-name {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.2;
        }

        .auth-logo-sub {
            font-size: 0.7rem;
            color: #64748b;
            font-weight: 400;
            letter-spacing: 0.03em;
        }

        /* Heading */
        .auth-heading {
            margin-bottom: 1.75rem;
            text-align: center;
        }

        .auth-heading h1 {
            font-size: 1.625rem;
            font-weight: 800;
            color: #0f172a;
        }

        .auth-heading p {
            font-size: 0.875rem;
            color: #64748b;
            line-height: 1.5;
        }

        /* Alert */
        .auth-alert-error {
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
            padding: 0.875rem 1rem;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-left: 3px solid #ef4444;
            border-radius: 0.5rem;
            margin-bottom: 1.25rem;
        }

        .auth-alert-error svg {
            color: #ef4444;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .auth-alert-error span {
            font-size: 0.875rem;
            color: #b91c1c;
            font-weight: 500;
        }

        /* Form group */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
        }

        .form-label span.required {
            color: #ef4444;
            margin-left: 2px;
        }

        /* Input wrapper */
        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        .form-input {
            width: 100%;
            /* Use important on ALL padding sides to beat global app.css override */
            padding-top: 0.6875rem !important;
            padding-bottom: 0.6875rem !important;
            padding-right: 0.875rem !important;
            padding-left: 2.75rem !important;
            font-size: 0.875rem !important;
            line-height: 1.25rem !important;
            color: #0f172a !important;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 0.5rem !important;
            box-shadow: none !important;
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background 0.15s ease !important;
        }

        /* Extra specificity to override global app.css padding-left !important */
        .input-wrapper .form-input,
        .input-password-wrapper .form-input {
            padding-left: 2.75rem !important;
        }

        .input-wrapper .form-input-password,
        .input-password-wrapper .form-input-password {
            padding-right: 2.75rem !important;
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        .form-input:focus {
            outline: none !important;
            background: #fff;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.12) !important;
        }

        .form-input.is-error {
            border-color: #f87171 !important;
            background: #fff5f5;
        }

        .form-input.is-error:focus {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.1) !important;
        }

        .form-input.is-valid {
            border-color: #34d399 !important;
        }

        /* Password field with toggle */
        .input-password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            color: #9ca3af;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 1.25rem;
            height: 1.25rem;
            transition: color 0.15s;
        }

        .password-toggle:hover {
            color: #3b82f6;
        }

        .form-input-password {
            padding-right: 2.75rem !important;
        }

        /* Validation message */
        .field-error {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            color: #ef4444;
            margin-top: 0.375rem;
            font-weight: 500;
            min-height: 1.25rem;
        }

        .field-error.hidden { display: none; }

        /* Remember + Forgot row */
        .auth-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .auth-checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .auth-checkbox-label input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 1.125rem;
            height: 1.125rem;
            cursor: pointer;
            border-radius: 0.5rem !important;
            border: 1.5px solid #e2e8f0 !important;
            padding: 0 !important;
            background-color: #f8fafc;
            position: relative;
            transition: all 0.15s ease;
        }

        .auth-checkbox-label input[type="checkbox"]:checked {
            background-color: #3b82f6;
            border-color: #3b82f6 !important;
        }

        .auth-checkbox-label input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 1.5px;
            width: 4px;
            height: 8px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .auth-checkbox-label span {
            font-size: 0.8125rem;
            color: #475569;
            font-weight: 500;
        }

        .auth-link {
            font-size: 0.8125rem;
            color: #3b82f6;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.15s;
        }

        .auth-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-auth {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            font-size: 0.9375rem;
            font-weight: 700;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(37,99,235,0.35);
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.01em;
        }

        .btn-auth::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .btn-auth:hover::before { opacity: 1; }
        .btn-auth:hover { box-shadow: 0 6px 20px rgba(37,99,235,0.45); transform: translateY(-1px); }
        .btn-auth:active { transform: translateY(0); box-shadow: 0 2px 8px rgba(37,99,235,0.3); }

        .btn-auth span { position: relative; z-index: 1; }
        .btn-auth svg  { position: relative; z-index: 1; }

        /* Divider */
        .auth-divider {
            position: relative;
            text-align: center;
            margin: 1.5rem 0;
        }

        .auth-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0; right: 0;
            height: 1px;
            background: #e2e8f0;
        }

        .auth-divider span {
            position: relative;
            background: #fff;
            padding: 0 0.75rem;
            font-size: 0.8125rem;
            color: #94a3b8;
            font-weight: 500;
        }

        /* Register link */
        .auth-register-row {
            text-align: center;
        }

        .auth-register-row p {
            font-size: 0.875rem;
            color: #64748b;
        }

        .auth-register-row a {
            color: #2563eb;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.15s;
        }

        .auth-register-row a:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        /* Spinner */
        .spinner {
            width: 1rem; height: 1rem;
            border: 2px solid rgba(255,255,255,0.35);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-wrapper {
                grid-template-columns: 1fr;
            }
            .auth-hero {
                display: none;
            }
            .auth-form-panel {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body style="background:#f8fafc; margin:0; padding:0; font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">

<div class="auth-wrapper">

    {{-- ===== LEFT: Hero Panel ===== --}}
    <div class="auth-hero">

        {{-- Background image --}}
        <img class="auth-hero-bg" src="{{ asset('images/auth-bg.jpg') }}" alt="Background Desa">

        {{-- Gradient fallback jika gambar belum ada --}}
        <div class="auth-hero-bg-placeholder"></div>

        {{-- Dark overlay --}}
        <div class="auth-hero-overlay"></div>

        {{-- Dot pattern --}}
        <div class="auth-hero-pattern"></div>

        {{-- Content: full panel, logo atas kiri, teks bawah kiri --}}
        <div class="auth-hero-content">

            {{-- Logo desa + icon tab (logo kota) — pojok kiri atas --}}
            <div class="auth-hero-logo">
                <img class="auth-hero-logo-icon" src="{{ $iconTabUrl }}" alt="Logo Kota Batu">
                <img class="auth-hero-logo-main" src="{{ $logoUrl }}" alt="Logo {{ $villageName }}">

                <div class="auth-hero-logo-sep"></div>
                <div>
                    <div class="auth-hero-logo-name">DESA {{ $villageName }}</div>
                    <div class="auth-hero-logo-sub">Kec. {{ $webSetting->subdistrict ?? '' }}, KOTA {{$city}}, {{ $province }}</div>
                </div>
            </div>

            {{-- Teks judul + info lokasi di kiri bawah --}}
            <div class="auth-hero-bottom">
                <h2 class="auth-hero-title">
                    Selamat Datang<br>
                    <span>di Panel Admin</span>
                </h2>
                <p class="auth-hero-desc">
                    Kelola informasi desa, berita, galeri, dan layanan masyarakat dari satu panel terintegrasi.
                </p>

                <!-- {{-- Info lokasi --}}
                <div class="auth-hero-location">
                    @if($address)
                    <div class="auth-hero-location-row">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="auth-hero-location-text">{{ $address }}</span>
                    </div>
                    @endif
                </div> -->
            </div>

        </div>
    </div>

    {{-- ===== RIGHT: Form Panel ===== --}}
    <div class="auth-form-panel">
        <div class="auth-form-inner">

            <!-- {{-- Logo & Village Name --}}
            <div class="auth-logo">
                <img src="{{ $logoUrl }}" alt="Logo {{ $villageName }}" onerror="this.style.display='none'">
                <div>
                    <div class="auth-logo-name">{{ $villageName }}</div>
                    <div class="auth-logo-sub">Portal Administrasi Desa</div>
                </div>
            </div> -->

            {{-- Heading --}}
            <div class="auth-heading">
                <h1>Masuk ke Akun</h1>
                <p>Masukkan kredensial Anda untuk mengakses panel admin.</p>
            </div>

            {{-- Server error alert --}}
            @if($errors->any())
            <div class="auth-alert-error" role="alert">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 8v4m0 4h.01"/>
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            {{-- Login Form --}}
            <form id="loginForm" action="{{ route('login') }}" method="POST" novalidate>
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label for="email" class="form-label">
                        Alamat Email <span class="required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input {{ $errors->has('email') ? 'is-error' : '' }}"
                            placeholder="admin@desaku.id"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            autofocus
                        >
                    </div>
                    <div class="field-error hidden" id="email-error">
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span id="email-error-text"></span>
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password" class="form-label">
                        Password <span class="required">*</span>
                    </label>
                    <div class="input-wrapper input-password-wrapper">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 11V7a5 5 0 0110 0v4"/>
                            </svg>
                        </span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input form-input-password {{ $errors->has('password') ? 'is-error' : '' }}"
                            placeholder="Masukkan password Anda"
                            autocomplete="current-password"
                        >
                        <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility">
                            {{-- Eye Open --}}
                            <svg id="eye-open" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{-- Eye Closed --}}
                            <svg id="eye-closed" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    <div class="field-error hidden" id="password-error">
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span id="password-error-text"></span>
                    </div>
                </div>

                {{-- Remember me row --}}
                <div class="auth-row">
                    <label class="auth-checkbox-label" for="remember">
                        <input type="checkbox" id="remember" name="remember">
                        <span>Ingat Saya</span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-auth" id="submitBtn">
                    <div class="spinner" id="loginSpinner"></div>
                    <span id="btnText">
                        Masuk ke Panel
                    </span>
                    <svg id="btnArrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="position:relative;z-index:1;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </form>

            {{-- Divider --}}
            <div class="auth-divider">
                <span>atau</span>
            </div>

            {{-- Register Link --}}
            <div class="auth-register-row">
                <p>Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ======================================================
       1. PASSWORD TOGGLE (show / hide)
    ====================================================== */
    const toggleBtn  = document.getElementById('togglePassword');
    const pwdInput   = document.getElementById('password');
    const eyeOpen    = document.getElementById('eye-open');
    const eyeClosed  = document.getElementById('eye-closed');

    toggleBtn.addEventListener('click', function () {
        const isPassword = pwdInput.type === 'password';
        pwdInput.type    = isPassword ? 'text' : 'password';
        eyeOpen.style.display   = isPassword ? 'none'  : 'block';
        eyeClosed.style.display = isPassword ? 'block' : 'none';
        toggleBtn.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
    });

    /* ======================================================
       2. FRONTEND VALIDATION
    ====================================================== */
    const emailInput  = document.getElementById('email');
    const form        = document.getElementById('loginForm');
    const submitBtn   = document.getElementById('submitBtn');
    const spinner     = document.getElementById('loginSpinner');
    const btnText     = document.getElementById('btnText');
    const btnArrow    = document.getElementById('btnArrow');

    // --- Helpers ---
    function showError(inputEl, errorDivId, errorTextId, msg) {
        inputEl.classList.add('is-error');
        inputEl.classList.remove('is-valid');
        const errDiv  = document.getElementById(errorDivId);
        const errText = document.getElementById(errorTextId);
        errText.textContent = msg;
        errDiv.classList.remove('hidden');
    }

    function clearError(inputEl, errorDivId) {
        inputEl.classList.remove('is-error');
        const errDiv = document.getElementById(errorDivId);
        errDiv.classList.add('hidden');
    }

    function markValid(inputEl) {
        inputEl.classList.remove('is-error');
        inputEl.classList.add('is-valid');
    }

    // --- Email validation ---
    function validateEmail() {
        const val = emailInput.value.trim();
        if (!val) {
            showError(emailInput, 'email-error', 'email-error-text', 'Email tidak boleh kosong.');
            return false;
        }
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(val)) {
            showError(emailInput, 'email-error', 'email-error-text', 'Format email tidak valid (contoh: admin@desa.id).');
            return false;
        }
        clearError(emailInput, 'email-error');
        markValid(emailInput);
        return true;
    }

    // --- Password validation ---
    function validatePassword() {
        const val = pwdInput.value;
        if (!val) {
            showError(pwdInput, 'password-error', 'password-error-text', 'Password tidak boleh kosong.');
            return false;
        }
        if (val.length < 6) {
            showError(pwdInput, 'password-error', 'password-error-text', 'Password minimal 6 karakter.');
            return false;
        }
        clearError(pwdInput, 'password-error');
        markValid(pwdInput);
        return true;
    }

    // --- Live validation on blur ---
    emailInput.addEventListener('blur', validateEmail);
    pwdInput.addEventListener('blur', validatePassword);

    // --- Clear error on typing ---
    emailInput.addEventListener('input', function () {
        if (emailInput.classList.contains('is-error')) validateEmail();
    });
    pwdInput.addEventListener('input', function () {
        if (pwdInput.classList.contains('is-error')) validatePassword();
    });

    /* ======================================================
       3. FORM SUBMIT
    ====================================================== */
    form.addEventListener('submit', function (e) {
        const emailOk = validateEmail();
        const pwdOk   = validatePassword();

        if (!emailOk || !pwdOk) {
            e.preventDefault();
            // Shake animation on first error field
            const firstError = document.querySelector('.is-error');
            if (firstError) {
                firstError.animate([
                    { transform: 'translateX(0)' },
                    { transform: 'translateX(-6px)' },
                    { transform: 'translateX(6px)' },
                    { transform: 'translateX(-4px)' },
                    { transform: 'translateX(4px)' },
                    { transform: 'translateX(0)' }
                ], { duration: 300, easing: 'ease-in-out' });
            }
            return;
        }

        // Show loading state
        spinner.style.display  = 'block';
        btnText.textContent    = 'Memproses...';
        btnArrow.style.display = 'none';
        submitBtn.disabled     = true;
        submitBtn.style.opacity = '0.85';
    });

});
</script>

</body>
</html>
