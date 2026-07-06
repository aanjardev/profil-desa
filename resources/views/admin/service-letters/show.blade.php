@extends('layouts.app')

@section('page_title', 'Detail Layanan Surat')
@section('page_subtitle', 'Tinjau rincian persyaratan dan informasi layanan surat.')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Kolom Utama ── --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $serviceLetter->letter_name }}</h2>
                    @if($serviceLetter->is_active)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Layanan Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-bold border border-gray-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                            Layanan Nonaktif
                        </span>
                    @endif
                </div>
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>

            <h3 class="text-sm font-bold text-gray-900 mb-3 border-b border-gray-100 pb-2">Persyaratan Dokumen</h3>
            <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed mb-6">
                {!! nl2br(e($serviceLetter->requirements)) !!}
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-amber-50/50 border border-amber-100 rounded-lg p-4 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-amber-800/60 uppercase tracking-wide">Estimasi Waktu</p>
                        <p class="text-sm font-bold text-amber-900">{{ $serviceLetter->estimated_time ?: 'Tidak ditentukan' }}</p>
                    </div>
                </div>
                <div class="bg-emerald-50/50 border border-emerald-100 rounded-lg p-4 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-emerald-800/60 uppercase tracking-wide">Biaya Layanan</p>
                        <p class="text-sm font-bold text-emerald-900">{{ $serviceLetter->fee ?: 'Gratis' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Kolom Sidebar ── --}}
    <div class="space-y-6">
        <div class="bg-gray-50 rounded-xl border border-gray-100 p-4 text-xs text-gray-500 space-y-2">
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">ID Layanan</span>
                <span>#{{ $serviceLetter->id }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Urutan Tampil</span>
                <span>{{ $serviceLetter->order_num }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Ditambahkan</span>
                <span>{{ $serviceLetter->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Diperbarui</span>
                <span>{{ $serviceLetter->updated_at->format('d M Y, H:i') }}</span>
            </div>
        </div>

        <div class="flex flex-col gap-3">
            <a href="{{ route('admin.service-letters.edit', $serviceLetter->id) }}"
               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Layanan
            </a>
            <a href="{{ route('admin.service-letters.index') }}"
               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar
            </a>
            <form action="{{ route('admin.service-letters.destroy', $serviceLetter->id) }}" method="POST"
                  onsubmit="return confirm('Hapus layanan {{ addslashes($serviceLetter->letter_name) }}?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-red-200 text-red-600 text-sm font-semibold rounded-lg hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus Layanan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
