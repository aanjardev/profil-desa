@extends('layouts.app')

@section('page_title', 'Kelola Dokumen PPID')
@section('page_subtitle', 'Arsip produk hukum, peraturan desa, dan dokumen publik lainnya.')

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
        <form action="{{ route('admin.ppid-documents.index') }}" method="GET" class="w-full sm:w-96 flex gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, nomor, atau tahun..."
                       style="padding-left: 2.5rem !important;"
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                @if(request('search'))
                    <a href="{{ route('admin.ppid-documents.index') }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                @endif
            </div>
        </form>

        <a href="{{ route('admin.ppid-documents.create') }}"
           class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Tambah Dokumen
        </a>
    </div>

    {{-- Tabel Dokumen PPID --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-4 w-12 text-center">No</th>
                    <th class="px-6 py-4">Nomor Register</th>
                    <th class="px-6 py-4 text-center">Tahun Register</th>
                    <th class="px-6 py-4">Judul Produk Hukum</th>
                    <th class="px-6 py-4">Jenis Produk Hukum</th>
                    <th class="px-6 py-4">Tanggal Ditetapkan</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi / Dokumen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($documents as $index => $doc)
                <tr class="hover:bg-blue-50/30 transition-colors group">
                    <td class="px-6 py-4 text-center text-sm font-medium text-gray-400">
                        {{ $documents->firstItem() + $index }}
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                        {{ $doc->register_no ?: '-' }}
                    </td>
                    <td class="px-6 py-4 text-center text-sm text-gray-700">
                        {{ $doc->year }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-bold text-gray-900 block line-clamp-2" title="{{ $doc->title }}">{{ $doc->title }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 text-xs font-semibold border border-amber-200">
                            {{ $doc->category }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $doc->established_date ? \Carbon\Carbon::parse($doc->established_date)->translatedFormat('j F Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($doc->is_active)
                            <span class="inline-flex items-center px-2 py-1 rounded-md bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200">Aktif</span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-md bg-gray-50 text-gray-600 text-xs font-semibold border border-gray-200">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            @if($doc->file_path)
                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold rounded-lg hover:bg-blue-100 transition-colors" title="Lihat/Unduh File">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                {{ $doc->file_label ?: 'File' }}
                            </a>
                            @else
                            <span class="text-xs text-gray-400 italic">Kosong</span>
                            @endif

                            <div class="w-px h-5 bg-gray-200 mx-1"></div>

                            <a href="{{ route('admin.ppid-documents.edit', $doc->id) }}"
                               class="p-1.5 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit Data">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900 mb-1">Belum Ada Dokumen PPID</h3>
                            <p class="text-sm text-gray-500 mb-4">Arsipkan produk hukum pertama Anda ke dalam sistem.</p>
                            <a href="{{ route('admin.ppid-documents.create') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-semibold rounded-lg hover:bg-blue-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Dokumen Baru
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($documents->hasPages())
    <div class="p-6 border-t border-gray-100 bg-gray-50/50">
        {{ $documents->links() }}
    </div>
    @endif
</div>
@endsection
