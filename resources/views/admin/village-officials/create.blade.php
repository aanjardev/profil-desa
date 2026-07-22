@extends('layouts.app')

@section('page_title', 'Tambah Perangkat Desa')
@section('page_subtitle', 'Masukkan data anggota perangkat desa beserta posisinya dalam struktur organisasi.')

@section('content')
<form action="{{ route('admin.village-officials.store') }}" method="POST" enctype="multipart/form-data"
      x-data="{
          photoPreview: null
      }">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kolom Kiri: Foto --}}
        <div class="space-y-6">
            {{-- Foto Perangkat --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Foto Perangkat</h3>

                <div class="relative w-full aspect-square rounded-xl overflow-hidden border-2 border-dashed border-gray-300 bg-gray-50 hover:border-blue-400 hover:bg-blue-50/30 transition-colors flex flex-col items-center justify-center cursor-pointer mb-3"
                     @click="$refs.photoInput.click()">
                    <template x-if="photoPreview">
                        <img :src="photoPreview" class="absolute inset-0 w-full h-full object-cover object-top">
                    </template>
                    <div class="relative z-10 text-center" :class="{ 'opacity-0': photoPreview }">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-600">Klik untuk pilih foto</p>
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP • Maks 2MB</p>
                    </div>
                    <template x-if="photoPreview">
                        <div class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="text-white text-sm font-semibold bg-black/50 px-3 py-1.5 rounded-lg">Ganti Foto</span>
                        </div>
                    </template>
                </div>

                <input type="file" name="photo" x-ref="photoInput" accept="image/*" class="sr-only"
                       @change="
                           const file = $event.target.files[0];
                           if (file) {
                               if (file.size > 2097152) { alert('Ukuran maks 2MB!'); $event.target.value = ''; return; }
                               photoPreview = URL.createObjectURL(file);
                           }
                       ">
                @error('photo')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror

                <p class="text-xs text-gray-400 text-center mt-2">Disarankan: foto portrait persegi (1:1)</p>
            </div>

            {{-- Status & Urutan --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Status & Urutan</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <div class="flex flex-col gap-2">
                            <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50/30 transition-colors has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                <input type="radio" name="status" value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'checked' : '' }} class="accent-blue-600">
                                <div>
                                    <span class="text-sm font-semibold text-gray-800">Aktif</span>
                                    <p class="text-xs text-gray-400">Tampil di halaman publik</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg border border-gray-200 hover:border-gray-300 transition-colors has-[:checked]:border-gray-400 has-[:checked]:bg-gray-50">
                                <input type="radio" name="status" value="tidak_aktif" {{ old('status') === 'tidak_aktif' ? 'checked' : '' }} class="accent-gray-500">
                                <div>
                                    <span class="text-sm font-semibold text-gray-800">Tidak Aktif</span>
                                    <p class="text-xs text-gray-400">Disembunyikan dari publik</p>
                                </div>
                            </label>
                        </div>
                        @error('status')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Removed Desktop Action Buttons to unify at the bottom --}}
        </div>

        {{-- Kolom Kanan: Data Diri & Posisi --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Data Diri --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-5 border-b border-gray-100 pb-3">Data Diri</h3>
                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required maxlength="255"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Contoh: Budi Santoso, S.IP.">
                        @error('name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="nip" class="block text-sm font-bold text-gray-700 mb-1">
                            NIP <span class="text-gray-400 font-normal">(Opsional)</span>
                        </label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip') }}" maxlength="50"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm font-mono"
                               placeholder="Contoh: 19850101 200901 1 001">
                        @error('nip')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="position" class="block text-sm font-bold text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                        <input type="text" name="position" id="position" value="{{ old('position') }}" required maxlength="150"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Contoh: Kepala Desa / Sekretaris Desa / Kaur Keuangan">
                        @error('position')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>            {{-- Tipe Jabatan --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-2 border-b border-gray-100 pb-3">Tipe Jabatan</h3>
                <p class="text-xs text-gray-500 mb-5">Pilih tipe jabatan. Posisi garis dan hierarki akan diatur di halaman Desain SOTK Visual.</p>

                <div class="space-y-5">
                    <div>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex items-center gap-2.5 cursor-pointer p-2.5 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50/30 transition-colors has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                <input type="radio" name="type" value="eksekutif" {{ old('type', 'eksekutif') === 'eksekutif' ? 'checked' : '' }} class="accent-blue-600">
                                <div>
                                    <span class="text-xs font-bold text-gray-800 block">Eksekutif</span>
                                    <span class="text-[10px] text-gray-400">Kades, Sekdes, Kasi, Kaur</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer p-2.5 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50/30 transition-colors has-[:checked]:border-purple-500 has-[:checked]:bg-purple-50">
                                <input type="radio" name="type" value="legislatif" {{ old('type') === 'legislatif' ? 'checked' : '' }} class="accent-purple-600">
                                <div>
                                    <span class="text-xs font-bold text-gray-800 block">Legislatif</span>
                                    <span class="text-[10px] text-gray-400">BPD &amp; anggotanya</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer p-2.5 rounded-lg border border-gray-200 hover:border-amber-300 hover:bg-amber-50/30 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50">
                                <input type="radio" name="type" value="kasun" {{ old('type') === 'kasun' ? 'checked' : '' }} class="accent-amber-600">
                                <div>
                                    <span class="text-xs font-bold text-gray-800 block">Kasun</span>
                                    <span class="text-[10px] text-gray-400">Kepala Dusun</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer p-2.5 rounded-lg border border-gray-200 hover:border-gray-300 hover:bg-gray-50/30 transition-colors has-[:checked]:border-gray-400 has-[:checked]:bg-gray-50">
                                <input type="radio" name="type" value="staf" {{ old('type') === 'staf' ? 'checked' : '' }} class="accent-gray-500">
                                <div>
                                    <span class="text-xs font-bold text-gray-800 block">Staf</span>
                                    <span class="text-[10px] text-gray-400">Staf pendukung</span>
                                </div>
                            </label>
                        </div>
                        @error('type')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    </div>

                    {{-- Atasan (Untuk Staf) --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Atasan (Khusus Staf) <span class="text-red-500">*</span></label>
                        <select name="parent_id" 
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm text-gray-700">
                            <option value="">Pilih Atasan (Jika Staf)</option>
                            @foreach(\App\Models\VillageOfficial::where('type', 'eksekutif')->orderBy('level')->orderBy('order_num')->get() as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }} - {{ $parent->position }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-[10px] text-gray-500">Pilih atasan jika perangkat ini adalah staf dari Kasi/Kaur tertentu.</p>
                        @error('parent_id')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Info box --}}
                <div class="mt-5 p-3 bg-blue-50 border border-blue-100 rounded-lg">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-xs text-blue-700 leading-relaxed">
                            Bagan SOTK publik akan dibuat secara otomatis berdasarkan <strong>Jabatan</strong> yang Anda isi. Pastikan penulisan jabatan sesuai (contoh: Kepala Desa, Sekretaris Desa, Kasi Kesra, Kaur Umum, Staf Kasi Kesra, Kasun Gondang).
                        </p>
                    </div>
                </div>
            </div>  </div>

            {{-- Tombol Aksi (Simpan & Batal) --}}
            <div class="flex gap-3">
                <a href="{{ route('admin.village-officials.index') }}" class="w-1/2 px-5 py-3 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors text-center">
                    Batal
                </a>
                <button type="submit" class="w-1/2 px-5 py-3 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-sm text-center">
                    Simpan Perangkat
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
