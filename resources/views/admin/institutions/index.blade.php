@extends('layouts.app')

@section('page_title', 'Kelola Lembaga Desa')
@section('page_subtitle', 'Kelola data lembaga-lembaga yang ada di desa.')

@section('content')

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 text-emerald-700">
    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white p-4 md:p-6 rounded-xl border border-gray-100 shadow-sm mb-6">
    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
        <form action="{{ route('admin.institutions.index') }}" method="GET" class="w-full xl:flex-1 flex flex-col sm:flex-row gap-3">
            {{-- Search --}}
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama lembaga..."
                       style="padding-left: 2.5rem !important;"
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
            </div>

            {{-- Custom Dropdown Filter Jenis --}}
            <div x-data="{
                    open: false,
                    selected: '{{ request('type') }}',
                    label: '{{ request('type') ? ($typeLabels[request('type')] ?? request('type')) : 'Semua Kategori' }}'
                }" class="relative min-w-[180px]">
                <input type="hidden" name="type" :value="selected">

                <button type="button"
                        @click="open = !open"
                        @keydown.escape.window="open = false"
                        class="w-full flex items-center justify-between gap-2 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 hover:border-blue-400 hover:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                    <span x-text="label" class="truncate"></span>
                    <svg class="w-4 h-4 text-gray-400 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="open"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     @click.outside="open = false"
                     class="absolute z-20 mt-1.5 w-full bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden"
                     x-cloak>
                    <div class="py-1.5 max-h-60 overflow-y-auto">
                        <button type="button"
                                @click="selected = ''; label = 'Semua Kategori'; open = false"
                                :class="selected === '' ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50'"
                                class="w-full text-left px-4 py-2.5 text-sm transition-colors flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-gray-400 shrink-0" :class="{ 'bg-blue-500': selected === '' }"></span>
                            Semua Kategori
                        </button>
                        @foreach($typeLabels as $key => $label)
                        <button type="button"
                                @click="selected = '{{ $key }}'; label = '{{ $label }}'; open = false"
                                :class="selected === '{{ $key }}' ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50'"
                                class="w-full text-left px-4 py-2.5 text-sm transition-colors flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full shrink-0"
                                  :class="selected === '{{ $key }}' ? 'bg-blue-500' : 'bg-gray-300'"></span>
                            {{ $label }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <button type="submit" class="px-5 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                Cari
            </button>
        </form>

        <div class="flex shrink-0 pt-4 xl:pt-0 border-t xl:border-t-0 border-gray-100">
            <a href="{{ route('admin.institutions.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm w-full sm:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Lembaga
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100 text-xs text-gray-500 font-bold uppercase tracking-wider">
                    <th class="px-6 py-4 w-16 text-center">No</th>
                    <th class="px-6 py-4 w-16">Logo</th>
                    <th class="px-6 py-4">Nama Lembaga</th>
                    <th class="px-6 py-4 whitespace-nowrap">Kategori</th>
                    <th class="px-6 py-4 whitespace-nowrap">Narahubung</th>
                    <th class="px-6 py-4 whitespace-nowrap">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($institutions as $institution)
                <tr onclick="window.location='{{ route('admin.institutions.show', $institution->id) }}'" class="hover:bg-gray-50/50 transition-colors group cursor-pointer">
                    <td class="px-6 py-4 text-center text-sm font-medium text-gray-500">
                        {{ ($institutions->currentPage() - 1) * $institutions->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-6 py-4">
                        @if($institution->logo)
                            <img src="{{ Storage::url($institution->logo) }}" alt="{{ $institution->name }}" class="w-10 h-10 object-contain rounded-lg border border-gray-200 bg-gray-50 p-1">
                        @else
                            <div class="w-10 h-10 rounded-lg border border-gray-100 bg-gray-100 flex items-center justify-center">
                                <span class="text-sm font-bold text-gray-400">{{ strtoupper(substr($institution->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <h4 class="text-sm font-bold text-gray-900 leading-snug line-clamp-1">{{ $institution->name }}</h4>
                            @if($institution->description)
                                <span class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $institution->description }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @php $colorClass = $typeColors[$institution->type] ?? 'bg-gray-100 text-gray-700'; @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold {{ $colorClass }}">
                            {{ $typeLabels[$institution->type] ?? $institution->type }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($institution->contact_person)
                            <span class="text-sm text-gray-700">{{ $institution->contact_person }}</span>
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($institution->is_active)
                            <div class="flex items-center gap-1.5 text-emerald-600 text-xs font-semibold">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                Publik
                            </div>
                        @else
                            <div class="flex items-center gap-1.5 text-gray-500 text-xs font-semibold">
                                <div class="w-1.5 h-1.5 rounded-full bg-gray-400"></div>
                                Nonaktif
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4" onclick="event.stopPropagation();">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.institutions.show', $institution->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Lihat Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <a href="{{ route('admin.institutions.edit', $institution->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.institutions.destroy', $institution->id) }}" method="POST" class="m-0 p-0 inline-flex" onsubmit="return confirm('Hapus lembaga {{ addslashes($institution->name) }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <h3 class="text-base font-bold text-gray-900 mb-1">Belum ada data lembaga</h3>
                            <p class="text-sm text-gray-500 mb-4">Mulai tambahkan data lembaga-lembaga yang ada di desa.</p>
                            <a href="{{ route('admin.institutions.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-100 transition-colors">
                                Tambah Lembaga
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $institutions->links() }}
</div>

<style>[x-cloak] { display: none !important; }</style>
@endsection
