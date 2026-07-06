@extends('layouts.app')

@section('page_title', 'Dashboard Admin')
@section('page_subtitle', 'Ringkasan aktivitas dan metrik utama sistem profil desa.')

@section('content')

{{-- 1. WELCOME BANNER --}}
<div class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 shadow-lg text-white">
    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
    <div class="absolute bottom-0 right-10 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
    
    <div class="relative p-6 sm:p-8 md:flex md:items-center md:justify-between gap-6">
        <div>
            <p class="text-blue-100 font-medium text-sm mb-1 uppercase tracking-wider">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            <h2 class="text-2xl sm:text-3xl font-extrabold mb-2">Selamat datang kembali, {{ auth()->user()->name }}!</h2>
        </div>
        
    </div>
</div>

{{-- 2. METRIC CARDS --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    {{-- Card 1: Publikasi --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4 hover:shadow-md transition-shadow group">
        <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-.586-1.414l-4.5-4.5A2 2 0 0012.586 3H12"></path></svg>
        </div>
        <div>
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Berita & Artikel</h4>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['posts']) }}</p>
        </div>
    </div>

    {{-- Card 2: Potensi Desa --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4 hover:shadow-md transition-shadow group">
        <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
        </div>
        <div>
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Wisata & UMKM</h4>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['tourism'] + $stats['umkm']) }}</p>
        </div>
    </div>

    {{-- Card 3: Layanan Publik --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4 hover:shadow-md transition-shadow group">
        <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center text-purple-600 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <div>
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Dokumen PPID</h4>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['ppid']) }}</p>
        </div>
    </div>

    {{-- Card 4: Surat --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4 hover:shadow-md transition-shadow group">
        <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center text-amber-600 group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </div>
        <div>
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Layanan Surat</h4>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['letters']) }}</p>
        </div>
    </div>
</div>

{{-- 3. QUICK ACTIONS & RECENT ACTIVITIES --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    {{-- Main Content: Recent Activities --}}
    <div class="lg:col-span-2 space-y-6">
        
        {{-- Tabel Berita Terbaru --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-.586-1.414l-4.5-4.5A2 2 0 0012.586 3H12"></path></svg>
                    <h3 class="text-sm font-bold text-gray-900">Artikel & Publikasi Terbaru</h3>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Lihat Semua &rarr;</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentPosts as $post)
                <div class="px-5 py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-gray-50 transition-colors">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 line-clamp-1 mb-0.5" title="{{ $post->title }}">{{ $post->title }}</h4>
                        <div class="flex items-center gap-3 text-xs text-gray-500">
                            <span class="inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>{{ $post->created_at->format('d M Y') }}</span>
                            <span class="inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>{{ $post->category ?? 'Berita' }}</span>
                        </div>
                    </div>
                    <div class="shrink-0 flex items-center gap-2">
                        @if($post->is_published)
                            <span class="px-2 py-1 text-[10px] font-bold tracking-wide uppercase bg-emerald-100 text-emerald-700 rounded-md">Aktif</span>
                        @else
                            <span class="px-2 py-1 text-[10px] font-bold tracking-wide uppercase bg-gray-100 text-gray-600 rounded-md">Tidak Aktif</span>
                        @endif
                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                    </div>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-sm text-gray-500">Belum ada publikasi berita.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Tabel Dokumen PPID Terbaru --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <h3 class="text-sm font-bold text-gray-900">Dokumen Publik (PPID) Terbaru</h3>
                </div>
                <a href="{{ route('admin.ppid-documents.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Lihat Semua &rarr;</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentDocuments as $doc)
                <div class="px-5 py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-gray-50 transition-colors">
                    <div class="flex gap-3 items-start">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 line-clamp-1 mb-0.5" title="{{ $doc->title }}">{{ $doc->title }}</h4>
                            <p class="text-xs text-gray-500">{{ $doc->category }} &bull; {{ $doc->year }}</p>
                        </div>
                    </div>
                    <div class="shrink-0">
                        <a href="{{ route('admin.ppid-documents.edit', $doc->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm">
                            Edit Dokumen
                        </a>
                    </div>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-sm text-gray-500">Belum ada dokumen PPID yang diunggah.</p>
                </div>
                @endforelse
            </div>
        </div>
        
    </div>

    {{-- Sidebar Content: Quick Actions --}}
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-sm font-bold text-gray-900">Jalan Pintas (Quick Actions)</h3>
            </div>
            <div class="p-4 grid grid-cols-1 gap-3">
                <a href="{{ route('admin.posts.create') }}" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-blue-300 hover:bg-blue-50 transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 group-hover:text-blue-700 transition-colors">Tulis Artikel Baru</p>
                        <p class="text-[11px] text-gray-500">Publikasikan berita terbaru desa</p>
                    </div>
                </a>

                <a href="{{ route('admin.ppid-documents.create') }}" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-purple-300 hover:bg-purple-50 transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 group-hover:text-purple-700 transition-colors">Unggah Dokumen</p>
                        <p class="text-[11px] text-gray-500">Peraturan desa & produk hukum</p>
                    </div>
                </a>
                
                <a href="{{ route('admin.tourisms.create') }}" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-emerald-300 hover:bg-emerald-50 transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">Tambah Wisata</p>
                        <p class="text-[11px] text-gray-500">Perkenalkan potensi desa wisata</p>
                    </div>
                </a>

                <a href="{{ route('admin.service-letters.create') }}" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-amber-300 hover:bg-amber-50 transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 group-hover:text-amber-700 transition-colors">Buat Layanan Surat</p>
                        <p class="text-[11px] text-gray-500">Informasi syarat administrasi</p>
                    </div>
                </a>
                
                @if(auth()->user()->role === 'superadmin')
                <div class="mt-2 border-t border-gray-100 pt-3">
                    <a href="{{ route('admin.users.index', ['tab' => 'pending']) }}" class="flex items-center justify-center gap-2 p-2.5 rounded-lg border border-gray-200 bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors text-xs font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Daftarkan Admin Baru
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
