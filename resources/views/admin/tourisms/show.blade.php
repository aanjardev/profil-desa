@extends('layouts.app')

@section('page_title', 'Detail Wisata')
@section('page_subtitle', 'Tinjau informasi lengkap tentang potensi wisata desa.')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <!-- Gambar Utama / Hero -->
    <div class="w-full h-64 md:h-96 relative bg-gray-900 group">
        <img src="{{ Storage::url($tourism->main_image) }}" alt="{{ $tourism->name }}" class="w-full h-full object-cover opacity-80">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-full p-6 md:p-8">
            <div class="flex flex-wrap items-center gap-2 mb-3">
                @if($tourism->is_active)
                    <span class="px-3 py-1 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-bold uppercase tracking-wide rounded-md backdrop-blur-sm">Dipublikasikan</span>
                @else
                    <span class="px-3 py-1 bg-gray-500/20 text-gray-300 border border-gray-500/30 text-xs font-bold uppercase tracking-wide rounded-md backdrop-blur-sm">Draft</span>
                @endif
                @if($tourism->tickets && count($tourism->tickets) > 0)
                    <span class="px-3 py-1 bg-blue-500/20 text-blue-300 border border-blue-500/30 text-xs font-bold tracking-wide rounded-md backdrop-blur-sm">🎟️ {{ count($tourism->tickets) }} Varian Tiket</span>
                @endif
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-white leading-tight">{{ $tourism->name }}</h2>
            <div class="flex items-center gap-2 text-gray-300 mt-2 text-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                {{ $tourism->location }}
            </div>
        </div>
    </div>

    <!-- Aksi -->
    <div class="border-b border-gray-100 bg-gray-50/50 p-4 flex flex-wrap items-center justify-between gap-4">
        <div class="text-sm text-gray-500 font-medium">
            Ditambahkan pada: {{ $tourism->created_at->format('d M Y') }}
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.tourisms.edit', $tourism->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-semibold rounded-lg hover:bg-blue-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Wisata
            </a>
            <a href="{{ route('admin.tourisms.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                Kembali
            </a>
        </div>
    </div>

    <div class="p-6 md:p-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-8">
                <!-- Deskripsi -->
                <div>
                    <h3 class="text-base font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Deskripsi & Daya Tarik</h3>
                    <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                        {!! nl2br(e($tourism->description)) !!}
                    </div>
                </div>

                <!-- Tiket -->
                @if($tourism->tickets && count($tourism->tickets) > 0)
                <div>
                    <h3 class="text-base font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Daftar Harga Tiket</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($tourism->tickets as $ticket)
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                                <span class="font-bold text-gray-800">{{ $ticket['name'] }}</span>
                                <span class="text-blue-600 font-semibold">{{ $ticket['price'] ?? 'Gratis' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Spots -->
                @if($tourism->spots && count($tourism->spots) > 0)
                <div>
                    <h3 class="text-base font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Spot & Wahana Dalam Area</h3>
                    <div class="space-y-3">
                        @foreach($tourism->spots as $spot)
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="font-bold text-gray-800">{{ $spot['name'] }}</h4>
                                    <span class="text-emerald-600 font-semibold text-sm bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">{{ $spot['price'] ?? 'Gratis' }}</span>
                                </div>
                                @if(isset($spot['description']) && $spot['description'])
                                    <p class="text-sm text-gray-500 mt-2">{{ $spot['description'] }}</p>
                                @endif
                                @if(isset($spot['order_link']) && $spot['order_link'])
                                    <div class="mt-3">
                                        <a href="{{ $spot['order_link'] }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 text-white text-xs font-semibold rounded-md hover:bg-emerald-700 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                            Pesan Online
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Galeri -->
                @if($tourism->supporting_images)
                <div>
                    <h3 class="text-base font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Galeri Foto</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($tourism->supporting_images as $img)
                            <div class="group relative aspect-square rounded-xl overflow-hidden bg-gray-100 cursor-pointer" onclick="window.open('{{ Storage::url($img['path']) }}', '_blank')">
                                <img src="{{ Storage::url($img['path']) }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                @if(isset($img['caption']) && $img['caption'])
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end">
                                        <p class="text-white text-xs p-3 font-medium line-clamp-2">{{ $img['caption'] }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-5">
                <div class="bg-blue-50/50 rounded-xl p-5 border border-blue-100 space-y-5">
                    @if($tourism->opening_hours)
                    <div>
                        <div class="flex items-center gap-2 text-blue-800 font-bold mb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Jam Operasional
                        </div>
                        <div class="text-sm font-medium text-gray-700 ml-6">{{ $tourism->opening_hours }}</div>
                    </div>
                    @endif

                    @if($tourism->facilities)
                    <div>
                        <div class="flex items-center gap-2 text-blue-800 font-bold mb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                            Fasilitas
                        </div>
                        <div class="text-sm font-medium text-gray-700 ml-6">
                            {!! nl2br(e($tourism->facilities)) !!}
                        </div>
                    </div>
                    @endif

                    @if($tourism->contact_person)
                    <div>
                        <div class="flex items-center gap-2 text-blue-800 font-bold mb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            Kontak / Narahubung
                        </div>
                        <div class="text-sm font-medium text-gray-700 ml-6">{{ $tourism->contact_person }}</div>
                    </div>
                    @endif

                    @if($tourism->maps_link)
                    <div class="pt-2">
                        <a href="{{ $tourism->maps_link }}" target="_blank" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-white border border-blue-200 text-blue-700 text-sm font-bold rounded-lg hover:bg-blue-50 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            Buka di Google Maps
                        </a>
                    </div>
                    @endif

                    @if($tourism->digital_map_link)
                    <div class="pt-2">
                        <a href="{{ $tourism->digital_map_link }}" target="_blank" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-blue-600 border border-transparent text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            Lihat Peta Digital Wisata
                        </a>
                    </div>
                    @endif

                    @if($tourism->order_link)
                    <div class="pt-2">
                        <a href="{{ $tourism->order_link }}" target="_blank" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-emerald-600 border border-transparent text-white text-sm font-bold rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Pesan Tiket Utama
                        </a>
                    </div>
                    @endif

                    @if($tourism->instagram_link)
                    <div class="pt-2">
                        <a href="{{ $tourism->instagram_link }}" target="_blank" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-purple-500 to-pink-500 border border-transparent text-white text-sm font-bold rounded-lg hover:opacity-90 transition-opacity shadow-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            Instagram
                        </a>
                    </div>
                    @endif

                    @if($tourism->youtube_link)
                    <div class="pt-2">
                        <a href="{{ $tourism->youtube_link }}" target="_blank" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-red-600 border border-transparent text-white text-sm font-bold rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            Youtube
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
