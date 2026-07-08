@extends('layouts.app')

@section('page_title', 'Kontak Darurat')
@section('page_subtitle', 'Kelola daftar kontak darurat untuk pelayanan masyarakat.')

@section('content')

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 text-emerald-700">
    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white p-4 md:p-6 rounded-xl border border-gray-100 shadow-sm mb-6 flex flex-col gap-4">
    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
        <div class="flex flex-col xl:flex-row gap-3 w-full xl:w-auto shrink-0 border-gray-100">
            <a href="{{ route('admin.emergency-contacts.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shrink-0 w-full sm:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kontak Darurat
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
                    <th class="px-6 py-4 whitespace-nowrap">Nama Layanan</th>
                    <th class="px-6 py-4 whitespace-nowrap">Kategori</th>
                    <th class="px-6 py-4 whitespace-nowrap">Nomor Telepon</th>
                    <th class="px-6 py-4 whitespace-nowrap">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($contacts as $contact)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-6 py-4 text-center text-sm font-medium text-gray-500">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <h4 class="text-sm font-bold text-gray-900 leading-snug">{{ $contact->name }}</h4>
                            @if($contact->description)
                            <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $contact->description }}</p>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2 py-1 bg-blue-50 text-blue-700 text-[11px] font-bold uppercase tracking-wide rounded-md">{{ $contact->category ?: '-' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 font-medium">
                            {{ $contact->phone }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($contact->is_active)
                            <div class="flex items-center gap-1.5 text-emerald-600 text-xs font-semibold">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                Aktif
                            </div>
                        @else
                            <div class="flex items-center gap-1.5 text-gray-500 text-xs font-semibold">
                                <div class="w-1.5 h-1.5 rounded-full bg-gray-400"></div>
                                Nonaktif
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.emergency-contacts.edit', $contact->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.emergency-contacts.destroy', $contact->id) }}" method="POST" class="m-0 p-0 inline-flex items-center" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kontak ini?');">
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
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="text-base font-bold text-gray-900 mb-1">Belum ada kontak darurat</h3>
                            <p class="text-sm text-gray-500 mb-4">Mulai tambahkan daftar kontak darurat untuk warga.</p>
                            <a href="{{ route('admin.emergency-contacts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-100 transition-colors">
                                Tambah Kontak
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
