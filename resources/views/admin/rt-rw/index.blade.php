@extends('layouts.app')

@section('page_title', 'Kelola Data RT/RW & Penduduk')
@section('page_subtitle', 'Kelola data demografi dan jumlah penduduk berdasarkan RT dan RW di desa.')

@section('content')
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 text-emerald-700">
    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    {{-- Header & Toolbar --}}
    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form action="{{ route('admin.rt-rws.index') }}" method="GET" class="w-full sm:w-96 flex gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari RW, RT, atau Nama Ketua..."
                       style="padding-left: 2.5rem !important;"
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                @if(request('search'))
                    <a href="{{ route('admin.rt-rws.index') }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                @endif
            </div>
        </form>

        <a href="{{ route('admin.rt-rws.create') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Tambah Data
        </a>
    </div>

    {{-- Tabel RT/RW --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-4 w-12 text-center">No</th>
                    <th class="px-6 py-4 text-center">RW / RT</th>
                    <th class="px-6 py-4">Ketua</th>
                    <th class="px-6 py-4 text-center">Laki-laki</th>
                    <th class="px-6 py-4 text-center">Perempuan</th>
                    <th class="px-6 py-4 text-center">Total Penduduk</th>
                    <th class="px-6 py-4 text-center">Jumlah KK</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($rtRws as $index => $item)
                <tr class="hover:bg-blue-50/30 transition-colors group">
                    <td class="px-6 py-4 text-center text-sm font-medium text-gray-400">
                        {{ $rtRws->firstItem() + $index }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex flex-col items-center justify-center gap-1">
                            <span class="px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-200">
                                RW {{ $item->rw_number }}
                            </span>
                            @if($item->rt_number)
                            <span class="px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-bold border border-blue-200">
                                RT {{ $item->rt_number }}
                            </span>
                            @else
                            <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Tingkat RW</span>
                            @endif
                        </span>
                        @if($item->area_name)
                        <div class="mt-2 text-[11px] font-semibold text-gray-500 uppercase tracking-wider bg-gray-50 px-2 py-0.5 rounded border border-gray-100">
                            {{ $item->area_name }}
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-gray-900">{{ $item->head_name }}</span>
                            @if($item->head_phone)
                            <span class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $item->head_phone }}
                            </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-semibold text-gray-700">{{ number_format($item->total_male, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-semibold text-gray-700">{{ number_format($item->total_female, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ number_format($item->total_penduduk, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-medium text-gray-600">{{ number_format($item->total_kk, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($item->is_active)
                            <span class="inline-flex items-center px-2 py-1 rounded-md bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200">Aktif</span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-md bg-gray-50 text-gray-600 text-xs font-semibold border border-gray-200">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.rt-rws.edit', $item->id) }}"
                               class="p-1.5 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit Data">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900 mb-1">Belum Ada Data Penduduk</h3>
                            <p class="text-sm text-gray-500 mb-4">Mulai tambahkan data rekapitulasi RT dan RW Anda ke dalam sistem.</p>
                            <a href="{{ route('admin.rt-rws.create') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-semibold rounded-lg hover:bg-blue-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Data Baru
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($rtRws->hasPages())
    <div class="p-6 border-t border-gray-100 bg-gray-50/50">
        {{ $rtRws->links() }}
    </div>
    @endif
</div>
@endsection
