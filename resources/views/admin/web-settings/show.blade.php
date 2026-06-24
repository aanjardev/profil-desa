@extends('layouts.app')

@section('page_title', 'Info Web')
@section('page_subtitle', 'Tinjauan identitas, kontak, dan logo desa yang saat ini aktif.')

@section('content')
<div class="mb-6 flex justify-end">
    <a href="{{ route('admin.web-settings.edit') }}" 
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-5 rounded-lg shadow-xs hover:shadow-md transition-all text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
        </svg>
        Edit Informasi
    </a>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg flex items-center gap-3">
    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column: Identitas & Kontak -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Identitas Utama -->
        <div class="bg-white rounded-xl shadow-xs border border-gray-100 p-6 md:p-8">
            <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2.5">
                <span class="w-1.5 h-4 bg-blue-600 rounded-full"></span>
                Identitas Desa
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6">
                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama Desa</span>
                    <span class="text-sm font-medium text-gray-800 mt-1 block">Desa {{ $webSetting->village_name ?: '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Kecamatan</span>
                    <span class="text-sm font-medium text-gray-800 mt-1 block">{{ $webSetting->subdistrict ?: '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Kabupaten / Kota</span>
                    <span class="text-sm font-medium text-gray-800 mt-1 block">{{ $webSetting->city ?: '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Provinsi</span>
                    <span class="text-sm font-medium text-gray-800 mt-1 block">{{ $webSetting->province ?: '-' }}</span>
                </div>
                <div class="md:col-span-2 mt-2 pt-4 border-t border-gray-50">
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Alamat Lengkap</span>
                    <span class="text-sm font-medium text-gray-700 mt-1 block leading-relaxed">{{ $webSetting->address ?: 'Belum diatur' }}</span>
                </div>
            </div>
        </div>

        <!-- Kontak & Media Sosial -->
        <div class="bg-white rounded-xl shadow-xs border border-gray-100 p-6 md:p-8">
            <h3 class="text-base font-bold text-gray-900 mb-5 flex items-center gap-2.5">
                <span class="w-1.5 h-4 bg-blue-600 rounded-full"></span>
                Kontak & Media Sosial
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kontak -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400 font-semibold uppercase">Telepon</span>
                            <span class="text-sm font-medium text-gray-800">{{ $webSetting->phone ?: '-' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-400 font-semibold uppercase">Email</span>
                            <span class="text-sm font-medium text-gray-800">{{ $webSetting->email ?: '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Media Sosial -->
                <div class="space-y-3.5 border-t md:border-t-0 md:border-l border-gray-50 pt-4 md:pt-0 md:pl-6">
                    <div class="flex items-center gap-2.5 text-sm">
                        <span class="w-6 text-gray-400 font-semibold text-xs">FB:</span>
                        @if($webSetting->facebook)
                            <a href="{{ $webSetting->facebook }}" target="_blank" class="text-blue-600 hover:underline font-medium truncate">{{ $webSetting->facebook }}</a>
                        @else
                            <span class="text-gray-400 italic">Belum diatur</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2.5 text-sm">
                        <span class="w-6 text-gray-400 font-semibold text-xs">IG:</span>
                        @if($webSetting->instagram)
                            <a href="{{ $webSetting->instagram }}" target="_blank" class="text-blue-600 hover:underline font-medium truncate">{{ $webSetting->instagram }}</a>
                        @else
                            <span class="text-gray-400 italic">Belum diatur</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2.5 text-sm">
                        <span class="w-6 text-gray-400 font-semibold text-xs">YT:</span>
                        @if($webSetting->youtube)
                            <a href="{{ $webSetting->youtube }}" target="_blank" class="text-blue-600 hover:underline font-medium truncate">{{ $webSetting->youtube }}</a>
                        @else
                            <span class="text-gray-400 italic">Belum diatur</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2.5 text-sm">
                        <span class="w-6 text-gray-400 font-semibold text-xs">TW:</span>
                        @if($webSetting->twitter)
                            <a href="{{ $webSetting->twitter }}" target="_blank" class="text-blue-600 hover:underline font-medium truncate">{{ $webSetting->twitter }}</a>
                        @else
                            <span class="text-gray-400 italic">Belum diatur</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Logo & Peta -->
    <div class="space-y-6">
        
        <!-- Logo & Favicon -->
        <div class="bg-white rounded-xl shadow-xs border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2.5">
                <span class="w-1.5 h-4 bg-blue-600 rounded-full"></span>
                Branding Desa
            </h3>
            
            <div class="space-y-6">
                <!-- Logo -->
                <div class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-3">Logo Aktif</span>
                    @if($webSetting->logo_path)
                        <img src="{{ $webSetting->logo_url }}" alt="Logo" class="max-h-24 object-contain">
                    @else
                        <img src="{{ asset('images/logo/logo-icon.svg') }}" alt="Logo Default" class="max-h-16 opacity-40">
                        <span class="text-xs text-gray-400 mt-2">Menggunakan Logo Default</span>
                    @endif
                </div>

                <!-- Favicon -->
                <div class="flex items-center justify-between p-3.5 bg-gray-50 rounded-lg border border-gray-200/50">
                    <div>
                        <span class="block text-xs font-semibold text-gray-500">Favicon</span>
                        <span class="text-[10px] text-gray-400">Ikon Tab Browser</span>
                    </div>
                    @if($webSetting->favicon_path)
                        <img src="{{ $webSetting->favicon_url }}" alt="Favicon" class="w-8 h-8 rounded border p-1 bg-white object-contain">
                    @else
                        <div class="w-8 h-8 rounded bg-gray-200 flex items-center justify-center text-gray-400 text-xs font-bold">
                            F
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Google Maps Embed -->
        <div class="bg-white rounded-xl shadow-xs border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2.5">
                <span class="w-1.5 h-4 bg-blue-600 rounded-full"></span>
                Peta Wilayah
            </h3>
            
            <div class="w-full aspect-video rounded-lg bg-gray-50 border overflow-hidden flex items-center justify-center">
                @if($webSetting->maps_embed)
                    {!! $webSetting->maps_embed !!}
                @else
                    <div class="text-center p-4">
                        <svg class="w-8 h-8 text-gray-300 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        <span class="text-xs text-gray-400">Embed Google Maps belum diatur</span>
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection
