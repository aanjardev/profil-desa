@extends('layouts.app')

@section('page_title', 'Arsip Berita')
@section('page_subtitle', 'Kelola daftar berita yang telah diarsipkan.')

@section('content')

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 text-emerald-700">
    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="mb-6">
    <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Berita Aktif
    </a>
</div>

<!-- Fitur Pencarian & Filter -->
<div class="bg-white p-4 md:p-6 rounded-xl border border-gray-100 shadow-sm mb-6">
    <form action="{{ route('admin.posts.archives') }}" method="GET" class="w-full flex flex-col lg:flex-row gap-3">
        <!-- Search -->
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul berita yang diarsipkan..." 
                   style="padding-left: 2.5rem !important;"
                   class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3 shrink-0">
            <!-- Filter Kategori (Alpine.js) -->
            <div x-data="{ open: false, category: '{{ request('category') }}' }" class="relative shrink-0 w-full sm:w-48">
                <input type="hidden" name="category" :value="category">
                <button type="button" @click="open = !open" @click.away="open = false" 
                        class="w-full flex items-center justify-between px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <span x-text="category ? category : 'Semua Kategori'"></span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="open" x-transition.opacity.duration.200ms style="display: none;"
                     class="absolute z-20 mt-2 w-full max-h-60 overflow-y-auto bg-white border border-gray-100 rounded-lg shadow-lg py-1">
                    <button type="button" @click="category = ''; open = false; $nextTick(() => { $el.closest('form').submit(); })" class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors" :class="category === '' ? 'font-bold text-blue-600 bg-blue-50/50' : 'text-gray-700'">Semua Kategori</button>
                    <template x-for="catOption in ['Pemerintahan', 'Pembangunan', 'Pendidikan', 'Kesehatan', 'Ekonomi', 'Pariwisata', 'Sosial', 'Lainnya']" :key="catOption">
                        <button type="button" @click="category = catOption; open = false; $nextTick(() => { $el.closest('form').submit(); })" class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors" :class="category === catOption ? 'font-bold text-blue-600 bg-blue-50/50' : 'text-gray-700'" x-text="catOption"></button>
                    </template>
                </div>
            </div>

            <!-- Filter Tahun (Alpine.js) -->
            <div x-data="{ open: false, year: '{{ request('year') }}' }" class="relative shrink-0 w-full sm:w-32">
                <input type="hidden" name="year" :value="year">
                <button type="button" @click="open = !open" @click.away="open = false" 
                        class="w-full flex items-center justify-between px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <span x-text="year ? year : 'Semua'"></span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="open" x-transition.opacity.duration.200ms style="display: none;"
                     class="absolute z-20 mt-2 w-full max-h-60 overflow-y-auto bg-white border border-gray-100 rounded-lg shadow-lg py-1">
                    <button type="button" @click="year = ''; open = false; $nextTick(() => { $el.closest('form').submit(); })" class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors" :class="year === '' ? 'font-bold text-blue-600 bg-blue-50/50' : 'text-gray-700'">Semua</button>
                    <template x-for="yearOption in {{ json_encode(range(date('Y'), 2020)) }}" :key="yearOption">
                        <button type="button" @click="year = yearOption; open = false; $nextTick(() => { $el.closest('form').submit(); })" class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors" :class="year == yearOption ? 'font-bold text-blue-600 bg-blue-50/50' : 'text-gray-700'" x-text="yearOption"></button>
                    </template>
                </div>
            </div>

            <!-- Sort (Alpine.js) -->
            <div x-data="{ open: false, sort: '{{ request('sort', 'newest') }}' }" class="relative shrink-0 w-full sm:w-40">
                <input type="hidden" name="sort" :value="sort">
                <button type="button" @click="open = !open" @click.away="open = false" 
                        class="w-full flex items-center justify-between px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <span x-text="sort === 'oldest' ? 'Terlama' : 'Terbaru'"></span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="open" x-transition.opacity.duration.200ms style="display: none;"
                     class="absolute z-20 mt-2 w-full bg-white border border-gray-100 rounded-lg shadow-lg overflow-hidden py-1">
                    <button type="button" @click="sort = 'newest'; open = false; $nextTick(() => { $el.closest('form').submit(); })" class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors" :class="sort === 'newest' ? 'font-bold text-blue-600 bg-blue-50/50' : 'text-gray-700'">Terbaru</button>
                    <button type="button" @click="sort = 'oldest'; open = false; $nextTick(() => { $el.closest('form').submit(); })" class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors" :class="sort === 'oldest' ? 'font-bold text-blue-600 bg-blue-50/50' : 'text-gray-700'">Terlama</button>
                </div>
            </div>
            
            <button type="submit" class="px-5 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition-colors focus:ring-2 focus:ring-gray-200 hidden sm:block">
                Cari
            </button>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors focus:ring-2 focus:ring-blue-500 block sm:hidden">
                Terapkan Filter
            </button>
        </div>
    </form>
</div>

<!-- Daftar Arsip -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50/50 text-xs uppercase text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 w-16 text-center font-bold">No</th>
                    <th class="px-6 py-4 w-[60%] font-bold">Judul Berita</th>
                    <th class="px-6 py-4 font-bold whitespace-nowrap">Kategori</th>
                    <th class="px-6 py-4 font-bold whitespace-nowrap text-center">Views</th>
                    <th class="px-6 py-4 font-bold whitespace-nowrap min-w-[150px]">Diarsipkan Pada</th>
                    <th class="px-6 py-4 text-right font-bold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($posts as $post)
                <tr onclick="window.location='{{ route('admin.posts.show', $post->id) }}'" class="hover:bg-gray-50/50 transition-colors group cursor-pointer">
                    <td class="px-6 py-4 text-center text-sm font-medium text-gray-500">
                        {{ ($posts->currentPage() - 1) * $posts->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-start gap-4">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Thumbnail" class="w-16 h-12 object-cover rounded shadow-sm shrink-0 grayscale opacity-80">
                            @else
                                <div class="w-16 h-12 bg-gray-100 rounded flex items-center justify-center text-gray-400 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 leading-snug line-clamp-2">{{ $post->title }}</h4>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $post->excerpt }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2 py-1 bg-gray-100 text-gray-600 text-[11px] font-bold uppercase tracking-wide rounded-md">{{ $post->category }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-50 border border-gray-200 text-gray-600 rounded-lg shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <span class="text-xs font-bold">{{ number_format($post->views, 0, ',', '.') }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 font-medium">{{ $post->deleted_at->format('d M Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $post->deleted_at->format('H:i') }} WIB</div>
                    </td>
                    <td class="px-6 py-4" onclick="event.stopPropagation();">
                        <div class="flex items-center justify-end gap-2">
                            <!-- Pulihkan -->
                            <form action="{{ route('admin.posts.restore', $post->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Pulihkan Berita">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </button>
                            </form>

                            <!-- Hapus Permanen -->
                            <form action="{{ route('admin.posts.force-delete', $post->id) }}" method="POST" onsubmit="return confirm('Peringatan: Berita ini akan dihapus PERMANEN beserta gambarnya. Lanjutkan?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Permanen">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <span class="text-base font-medium">Tabel arsip kosong</span>
                            <span class="text-sm mt-1">Tidak ada berita yang sedang diarsipkan.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
        {{ $posts->links() }}
    </div>
    @endif
</div>

@endsection
