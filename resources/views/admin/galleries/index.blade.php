@extends('layouts.app')

@section('page_title', 'Galeri Desa')
@section('page_subtitle', 'Kelola dokumentasi foto dan gambar kegiatan desa.')

@section('content')

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 text-emerald-700">
    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <h2 class="text-lg font-bold text-gray-900">Koleksi Galeri</h2>
    
    <div class="flex items-center gap-3 w-full sm:w-auto">
        <!-- Form Filter Periode (Custom Alpine.js Dropdown) -->
        <form action="{{ route('admin.galleries.index') }}" method="GET" class="flex-1 sm:flex-none" x-data="{ open: false, selectedValue: '{{ request('period') }}' }">
            <input type="hidden" name="period" x-model="selectedValue">
            <div class="relative w-full sm:w-auto" @click.away="open = false">
                
                <!-- Dropdown Trigger -->
                <button type="button" @click="open = !open" 
                    class="flex items-center justify-between w-full sm:w-[180px] pl-4 pr-3 py-2 bg-gray-50 border hover:border-gray-300 hover:bg-white rounded-lg text-sm font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors shadow-sm"
                    :class="open ? 'border-blue-500 bg-white ring-2 ring-blue-500/20' : 'border-gray-200'">
                    
                    <span class="truncate">
                        @if(request('period'))
                            @php
                                $selectedDate = \Carbon\Carbon::createFromFormat('Y-m', request('period'));
                            @endphp
                            {{ $selectedDate->translatedFormat('F Y') }}
                        @else
                            Semua Waktu
                        @endif
                    </span>
                    
                    <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Overlay List -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute z-50 mt-1.5 w-full sm:w-[200px] right-0 sm:left-0 bg-white border border-gray-100 rounded-xl shadow-lg py-1.5 overflow-hidden"
                     style="display: none;">
                    
                    <ul class="max-h-60 overflow-y-auto" style="scrollbar-width: thin;">
                        <li>
                            <button type="button" @click="selectedValue = ''; open = false; $nextTick(() => { $el.closest('form').submit() })" 
                                class="w-full text-left px-4 py-2.5 text-sm transition-colors flex items-center justify-between
                                {{ request('period') == '' ? 'bg-blue-50/50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-50 font-medium' }}">
                                Semua Waktu
                                @if(request('period') == '')
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </button>
                        </li>
                        
                        @foreach($periods as $period)
                            @php
                                $date = \Carbon\Carbon::createFromFormat('Y-m', $period);
                            @endphp
                            <li>
                                <button type="button" @click="selectedValue = '{{ $period }}'; open = false; $nextTick(() => { $el.closest('form').submit() })" 
                                    class="w-full text-left px-4 py-2.5 text-sm transition-colors flex items-center justify-between
                                    {{ request('period') == $period ? 'bg-blue-50/50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-50 font-medium' }}">
                                    {{ $date->translatedFormat('F Y') }}
                                    @if(request('period') == $period)
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    @endif
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </form>

        <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span class="hidden sm:inline">Tambah Gambar</span>
        </a>
    </div>
</div>

@if($galleries->count() > 0)
    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-6">
        @foreach($galleries as $gallery)
            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow group flex flex-col relative">
                <!-- Date Badge -->
                <div class="absolute top-3 right-3 z-10 bg-black/60 backdrop-blur-md text-white text-[10px] font-bold px-2.5 py-1 rounded-md tracking-wider">
                    {{ $gallery->created_at->translatedFormat('M Y') }}
                </div>

                <!-- Image -->
                <div class="aspect-video bg-gray-100 relative overflow-hidden">
                    <img src="{{ str_starts_with($gallery->image_path, 'images/') ? asset($gallery->image_path) : asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title ?? 'Gallery Image' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                
                <!-- Content -->
                <div class="p-4 flex-1 flex flex-col">
                    <h4 class="font-semibold text-gray-900 text-sm line-clamp-1 mb-1">{{ $gallery->title ?: 'Tanpa Judul' }}</h4>
                    <p class="text-xs text-gray-500 line-clamp-2 mb-3 flex-1">{{ $gallery->description ?: 'Tidak ada deskripsi.' }}</p>
                    
                    <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-50">
                        <span class="text-[11px] font-medium text-gray-400">
                            Diperbarui {{ $gallery->updated_at->diffForHumans() }}
                        </span>
                        
                        <!-- Actions -->
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.galleries.edit', $gallery->id) }}" class="text-blue-500 hover:text-blue-700 p-1.5 rounded-lg hover:bg-blue-50 transition-colors" title="Edit Gambar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50 transition-colors" title="Hapus Gambar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $galleries->appends(request()->query())->links() }}
    </div>
@else
    <div class="bg-white rounded-xl border border-gray-100 border-dashed p-12 text-center flex flex-col items-center justify-center">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
        <h3 class="text-base font-bold text-gray-900 mb-1">
            {{ request('period') ? 'Tidak ada foto pada periode ini' : 'Belum ada foto' }}
        </h3>
        <p class="text-sm text-gray-500 mb-4">
            {{ request('period') ? 'Coba pilih periode waktu lain atau unggah foto baru.' : 'Mulai bangun dokumentasi galeri desa dengan mengunggah gambar pertama Anda.' }}
        </p>
        <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-100 transition-colors">
            Upload Gambar
        </a>
    </div>
@endif

@endsection
