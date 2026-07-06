@extends('layouts.app')

@section('page_title', 'Manajemen User')
@section('page_subtitle', 'Kelola daftar pengguna sistem dan daftarkan email undangan baru.')

@section('content')
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 text-emerald-700">
    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex items-center gap-3 text-red-700">
    <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <span class="font-medium text-sm">{{ session('error') }}</span>
</div>
@endif

@if($errors->any())
<div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex flex-col gap-1 text-red-700">
    @foreach ($errors->all() as $error)
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span class="font-medium text-sm">{{ $error }}</span>
        </div>
    @endforeach
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ tab: '{{ $activeTab }}' }">
    {{-- Tabs Header --}}
    <div class="flex border-b border-gray-100 bg-gray-50/50">
        <button @click="tab = 'users'" 
                :class="{'border-blue-600 text-blue-600 bg-white': tab === 'users', 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50': tab !== 'users'}"
                class="flex-1 sm:flex-none px-6 py-4 text-sm font-bold border-b-2 transition-all flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Pengguna Aktif
        </button>
        <button @click="tab = 'pending'" 
                :class="{'border-blue-600 text-blue-600 bg-white': tab === 'pending', 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50': tab !== 'pending'}"
                class="flex-1 sm:flex-none px-6 py-4 text-sm font-bold border-b-2 transition-all flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            Email Undangan (Pending)
        </button>
    </div>

    {{-- TAB 1: PENGGUNA AKTIF --}}
    <div x-show="tab === 'users'" x-transition.opacity class="animate-fade-in">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4 w-12 text-center">#</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Alamat Email</th>
                        <th class="px-6 py-4">Peran (Role)</th>
                        <th class="px-6 py-4">Bergabung</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $index => $user)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="px-6 py-4 text-center text-sm font-medium text-gray-400">
                            {{ $users->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-gray-900 block">{{ $user->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4">
                            @if($user->role === 'superadmin')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-purple-50 text-purple-700 text-xs font-semibold border border-purple-200">Superadmin</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-200">Admin</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $user->created_at->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Edit Button --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                    class="p-1.5 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors inline-block" title="Edit Pengguna">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                
                                {{-- Delete Button (Disabled if self) --}}
                                @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ addslashes($user->name) }}? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Pengguna">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 text-sm">Tidak ada data pengguna ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="p-6 border-t border-gray-100 bg-white">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    {{-- TAB 2: EMAIL UNDANGAN --}}
    <div x-show="tab === 'pending'" style="display: none;" x-transition.opacity class="animate-fade-in">
        {{-- Form Tambah Email --}}
        <div class="p-6 bg-blue-50/50 border-b border-blue-100">
            <h4 class="text-sm font-bold text-blue-900 mb-2">Daftarkan Email Baru</h4>
            <p class="text-xs text-blue-700/80 mb-4">Hanya email yang didaftarkan di sini yang dapat mendaftar (Register) ke dalam sistem panel admin.</p>
            
            <form action="{{ route('admin.users.email.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3 max-w-2xl">
                @csrf
                <div class="flex-1">
                    <input type="email" name="email" required placeholder="Masukkan alamat email..."
                           class="w-full px-4 py-2.5 bg-white border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm placeholder-gray-400">
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    Daftarkan Email
                </button>
            </form>
        </div>

        {{-- Tabel Email --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4 w-12 text-center">#</th>
                        <th class="px-6 py-4">Alamat Email</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4">Didaftarkan Pada</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendingEmails as $index => $pending)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4 text-center text-sm font-medium text-gray-400">
                            {{ $pendingEmails->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-gray-900 block">{{ $pending->email }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($pending->status === 'registered')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200">Terdaftar</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 text-xs font-semibold border border-amber-200">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $pending->created_at->translatedFormat('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.users.email.destroy', $pending->id) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Hapus email ini dari daftar undangan? Jika sudah mendaftar, akun pengguna tersebut TIDAK akan terhapus secara otomatis.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Email">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-900 mb-1">Belum Ada Email Terdaftar</h3>
                                <p class="text-sm text-gray-500">Gunakan formulir di atas untuk mengundang pengguna baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pendingEmails->hasPages())
        <div class="p-6 border-t border-gray-100 bg-white">
            {{ $pendingEmails->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
