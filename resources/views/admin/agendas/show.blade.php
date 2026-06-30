@extends('layouts.app')

@section('page_title', 'Detail Agenda')
@section('page_subtitle', 'Informasi lengkap tentang agenda kegiatan desa.')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="p-6 md:p-8">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-6">
            <div>
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wide rounded-md">{{ $agenda->audience }}</span>
                    @if($agenda->status === 'published')
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wide rounded-md">Dipublikasikan</span>
                    @elseif($agenda->status === 'draft')
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold uppercase tracking-wide rounded-md">Draft</span>
                    @else
                        <span class="px-3 py-1 bg-red-50 text-red-700 text-xs font-bold uppercase tracking-wide rounded-md">Dibatalkan</span>
                    @endif
                </div>
                <h2 class="text-2xl font-bold text-gray-900 leading-tight">{{ $agenda->title }}</h2>
                <div class="flex items-center gap-4 text-sm text-gray-500 mt-2">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Dibuat pada {{ $agenda->created_at->format('d M Y') }}
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('admin.agendas.edit', $agenda->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-semibold rounded-lg hover:bg-blue-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit
                </a>
                <a href="{{ route('admin.agendas.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Deskripsi Kegiatan</h3>
                    <div class="prose prose-sm max-w-none text-gray-700">
                        {!! nl2br(e($agenda->description)) !!}
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 space-y-5 h-fit">
                <div>
                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal</div>
                    <div class="text-sm font-medium text-gray-900">
                        {{ \Carbon\Carbon::parse($agenda->start_date)->format('d F Y') }}
                        @if($agenda->end_date && $agenda->end_date !== $agenda->start_date)
                            s/d {{ \Carbon\Carbon::parse($agenda->end_date)->format('d F Y') }}
                        @endif
                    </div>
                </div>
                
                @if($agenda->start_time)
                <div>
                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Waktu</div>
                    <div class="text-sm font-medium text-gray-900">
                        {{ \Carbon\Carbon::parse($agenda->start_time)->format('H:i') }}
                        @if($agenda->end_time)
                            - {{ \Carbon\Carbon::parse($agenda->end_time)->format('H:i') }} WIB
                        @else
                            WIB - Selesai
                        @endif
                    </div>
                </div>
                @endif

                <div>
                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Lokasi</div>
                    <div class="text-sm font-medium text-gray-900">{{ $agenda->location }}</div>
                    @if($agenda->maps_link)
                        <a href="{{ $agenda->maps_link }}" target="_blank" class="inline-flex items-center gap-1.5 mt-1 text-sm text-blue-600 hover:text-blue-700 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Lihat di Google Maps
                        </a>
                    @endif
                </div>

                @if($agenda->organizer)
                <div>
                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Penyelenggara</div>
                    <div class="text-sm font-medium text-gray-900">{{ $agenda->organizer }}</div>
                </div>
                @endif

                @if($agenda->contact_person)
                <div>
                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Narahubung</div>
                    <div class="text-sm font-medium text-gray-900">{{ $agenda->contact_person }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
