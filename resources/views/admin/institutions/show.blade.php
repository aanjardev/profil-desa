@extends('layouts.app')

@section('page_title', 'Detail Lembaga')
@section('page_subtitle', 'Tinjau informasi lengkap tentang lembaga desa.')

@section('content')

@php
    $typeColor = $typeColors[$institution->type] ?? 'bg-gray-100 text-gray-700';
    $typeLabel = $typeLabels[$institution->type] ?? $institution->type;
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Kolom Kiri / Sidebar ── --}}
    <div class="space-y-6">

        {{-- Kartu Identitas --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center">
            @if($institution->logo)
                <img src="{{ Storage::url($institution->logo) }}" alt="{{ $institution->name }}"
                     class="w-24 h-24 object-contain rounded-xl border border-gray-200 bg-gray-50 p-2 mb-4">
            @else
                <div class="w-24 h-24 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center mb-4">
                    <span class="text-4xl font-bold text-gray-300">{{ strtoupper(substr($institution->name, 0, 1)) }}</span>
                </div>
            @endif

            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold border {{ $typeColor }} mb-3">
                {{ $typeLabel }}
            </span>

            <h2 class="text-lg font-bold text-gray-900 leading-tight mb-3">{{ $institution->name }}</h2>

            @if($institution->is_active)
                <div class="flex items-center gap-1.5 text-emerald-600 text-sm font-semibold">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    Aktif & Dipublikasikan
                </div>
            @else
                <div class="flex items-center gap-1.5 text-gray-500 text-sm font-semibold">
                    <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                    Nonaktif
                </div>
            @endif
        </div>

        {{-- Stats --}}
        <div class="bg-gray-50 rounded-xl border border-gray-100 p-4 text-xs text-gray-500 space-y-2">
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">ID Lembaga</span>
                <span>#{{ $institution->id }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Foto Galeri</span>
                <span class="font-bold text-gray-800">{{ count($institution->images ?? []) }} foto</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Ditambahkan</span>
                <span>{{ $institution->created_at->format('d M Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Diperbarui</span>
                <span>{{ $institution->updated_at->format('d M Y') }}</span>
            </div>
        </div>

        {{-- Aksi --}}
        <div class="flex flex-col gap-3">
            <a href="{{ route('admin.institutions.edit', $institution->id) }}"
               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Data Lembaga
            </a>
            <a href="{{ route('admin.institutions.index') }}"
               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar
            </a>
            <form action="{{ route('admin.institutions.destroy', $institution->id) }}" method="POST"
                  onsubmit="return confirm('Hapus lembaga {{ addslashes($institution->name) }}? Semua data terkait juga akan terhapus.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-red-200 text-red-600 text-sm font-semibold rounded-lg hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus Lembaga
                </button>
            </form>
        </div>
    </div>

    {{-- ── Kolom Utama ── --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Deskripsi --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Tentang Lembaga</h3>
            @if($institution->description)
                <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($institution->description)) !!}
                </div>
            @else
                <p class="text-sm text-gray-400 italic">Belum ada deskripsi untuk lembaga ini.</p>
            @endif
        </div>

        {{-- Narahubung --}}
        @if($institution->contact_person)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-900 mb-3 border-b border-gray-100 pb-3">Narahubung</h3>
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </div>
                <p class="text-sm font-semibold text-gray-800">{{ $institution->contact_person }}</p>
            </div>
        </div>
        @endif

        {{-- Galeri Foto --}}
        @if($institution->images && count($institution->images) > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">
                Galeri Foto
                <span class="text-sm font-normal text-gray-400 ml-2">({{ count($institution->images) }} foto)</span>
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach($institution->images as $img)
                <div class="group relative aspect-square rounded-xl overflow-hidden bg-gray-100 cursor-pointer"
                     onclick="window.open('{{ Storage::url($img['path']) }}', '_blank')">
                    <img src="{{ Storage::url($img['path']) }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                        </svg>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Susunan Pengurus --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
                <h3 class="text-base font-bold text-gray-900">
                    Susunan Pengurus
                    <span class="text-sm font-normal text-gray-400 ml-2">({{ $institution->members->count() }} orang)</span>
                </h3>
                <a href="{{ route('admin.institutions.edit', $institution->id) }}"
                   class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                    + Tambah Anggota
                </a>
            </div>

            @if($institution->members->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($institution->members as $member)
                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-gray-200 transition-colors">
                        @if($member->photo)
                            <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}"
                                 class="w-12 h-12 rounded-full object-cover object-top border-2 border-white shadow-sm shrink-0">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 border-2 border-white shadow-sm flex items-center justify-center shrink-0">
                                <span class="text-base font-bold text-blue-600">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $member->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $member->position }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-10 h-10 text-gray-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-400">Belum ada pengurus terdaftar.</p>
                    <a href="{{ route('admin.institutions.edit', $institution->id) }}"
                       class="inline-flex items-center gap-1.5 mt-3 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-100 transition-colors">
                        Tambah Pengurus
                    </a>
                </div>
            @endif
        </div>

    </div>{{-- /Kolom Utama --}}
</div>

@endsection
