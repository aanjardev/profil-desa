@extends('layouts.app')

@section('page_title', 'Berita & Artikel')
@section('page_subtitle', 'Kelola informasi, pengumuman, dan agenda desa untuk warga.')

@section('content')

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 text-emerald-700">
    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<!-- Fitur Pencarian & Filter -->
<div class="bg-white p-4 md:p-6 rounded-xl border border-gray-100 shadow-sm mb-6 flex flex-col gap-4">
    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
        <form action="{{ route('admin.posts.index') }}" method="GET" class="w-full xl:flex-1 flex flex-col lg:flex-row gap-3">
        <!-- Search -->
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul artikel..." 
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

        <div class="flex flex-col sm:flex-row gap-3 w-full xl:w-auto shrink-0 pt-4 xl:pt-0 border-t xl:border-t-0 border-gray-100">
            <a href="{{ route('admin.posts.archives') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors shadow-sm focus:ring-2 focus:ring-gray-200 shrink-0 w-full sm:w-auto">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                Lihat Arsip
            </a>
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shrink-0 w-full sm:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Tulis Artikel
            </a>
        </div>
    </div>
</div>

<!-- Table Daftar Berita -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100 text-xs text-gray-500 font-bold uppercase tracking-wider">
                    <th class="px-6 py-4 w-16 text-center">No</th>
                    <th class="px-6 py-4 w-[40%]">Informasi Artikel</th>
                    <th class="px-6 py-4 whitespace-nowrap">Kategori</th>
                    <th class="px-6 py-4 whitespace-nowrap text-center">Views</th>
                    <th class="px-6 py-4 whitespace-nowrap min-w-[150px]">Tgl Dibuat</th>
                    <th class="px-6 py-4 whitespace-nowrap">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
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
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Thumbnail" class="w-16 h-12 object-cover rounded shadow-sm shrink-0">
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
                            <span class="inline-flex px-2 py-1 bg-blue-50 text-blue-700 text-[11px] font-bold uppercase tracking-wide rounded-md">{{ $post->category }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-50 border border-gray-200 text-gray-600 rounded-lg shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <span class="text-xs font-bold">{{ number_format($post->views, 0, ',', '.') }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 font-medium">{{ $post->created_at->format('d M Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $post->created_at->format('H:i') }} WIB</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($post->is_published)
                            <div class="flex items-center gap-1.5 text-emerald-600 text-xs font-semibold">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                Publik
                            </div>
                        @else
                            <div class="flex items-center gap-1.5 text-gray-500 text-xs font-semibold">
                                <div class="w-1.5 h-1.5 rounded-full bg-gray-400"></div>
                                Draft
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4" onclick="event.stopPropagation();">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.posts.show', $post->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Lihat Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Berita">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="m-0 p-0 inline-flex items-center" onsubmit="return confirm('Apakah Anda yakin ingin mengarsipkan artikel ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Arsipkan Berita">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-.586-1.414l-4.5-4.5A2 2 0 0012.586 3H12"></path></svg>
                            </div>
                            <h3 class="text-base font-bold text-gray-900 mb-1">Belum ada artikel ditemukan</h3>
                            <p class="text-sm text-gray-500 mb-4">Mulai bagikan informasi, berita, atau pengumuman pertama Anda.</p>
                            @if(!request('search') && !request('category'))
                            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-100 transition-colors">
                                Tulis Artikel
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $posts->links() }}
</div>

@endsection
