@extends('layouts.app')

@section('page_title', 'Tambah Lembaga Desa')
@section('page_subtitle', 'Tambahkan data lembaga baru beserta pengurus/anggotanya.')

@section('content')
<form action="{{ route('admin.institutions.store') }}" method="POST" enctype="multipart/form-data"
      x-data="{ members: [], galleryPreviews: [] }">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Kolom Kanan: Sidebar ── --}}
        <div class="space-y-6">

            {{-- Logo + Status dalam satu kartu compact --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Logo & Status</h3>

                {{-- Logo compact --}}
                <div x-data="{ logoPreview: null }" class="mb-5">
                    <label class="block text-xs font-bold text-gray-600 mb-2">Logo <span class="font-normal text-gray-400">(Opsional)</span></label>
                    <div class="flex items-center gap-4">
                        {{-- Preview kecil --}}
                        <div class="relative w-16 h-16 rounded-xl overflow-hidden border-2 border-dashed border-gray-300 bg-gray-50 hover:border-blue-400 hover:bg-blue-50/30 transition-colors flex items-center justify-center cursor-pointer shrink-0"
                             @click="$refs.logoInput.click()">
                            <template x-if="logoPreview">
                                <img :src="logoPreview" class="absolute inset-0 w-full h-full object-contain p-1.5">
                            </template>
                            <div :class="{ 'opacity-0': logoPreview }">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <button type="button" @click="$refs.logoInput.click()"
                                    class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors block">
                                <span x-text="logoPreview ? 'Ganti Logo' : 'Pilih Logo'"></span>
                            </button>
                            <p class="text-xs text-gray-400 mt-0.5">JPG, PNG, SVG · maks 2MB</p>
                        </div>
                    </div>
                    <input type="file" name="logo" x-ref="logoInput" accept="image/*,image/svg+xml" class="sr-only"
                           @change="
                               const f = $event.target.files[0];
                               if (f) { if (f.size > 2097152) { alert('Maks 2MB!'); return; } logoPreview = URL.createObjectURL(f); }
                           ">
                    @error('logo')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Kategori (Custom Dropdown) --}}
                <div class="mb-5" x-data="{
                        open: false,
                        selected: '{{ old('type') }}',
                        label: '{{ old('type') ? ($typeLabels[old('type')] ?? '') : '' }}'
                    }">
                    <label class="block text-xs font-bold text-gray-600 mb-2">Kategori Lembaga <span class="text-red-500">*</span></label>
                    <input type="hidden" name="type" :value="selected">

                    <button type="button"
                            @click="open = !open"
                            @keydown.escape.window="open = false"
                            class="w-full flex items-center justify-between gap-2 px-3.5 py-2.5 bg-gray-50 border rounded-lg text-sm transition-colors"
                            :class="open ? 'border-blue-500 ring-2 ring-blue-500/20 bg-white' : 'border-gray-200 hover:border-blue-400 hover:bg-white'">
                        <span :class="selected ? 'text-gray-800' : 'text-gray-400'" x-text="label || '— Pilih Kategori —'"></span>
                        <svg class="w-4 h-4 text-gray-400 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-1"
                         @click.outside="open = false"
                         class="absolute z-30 mt-1.5 w-full bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden"
                         x-cloak style="min-width: 200px;">
                        <div class="p-1.5 space-y-0.5">
                            @foreach($typeLabels as $key => $label)
                            @php
                                $dotColors = [
                                    'kemasyarakatan' => 'bg-blue-500',
                                    'pemerintahan'   => 'bg-purple-500',
                                    'ekonomi'        => 'bg-emerald-500',
                                    'kepemudaan'     => 'bg-indigo-500',
                                    'keagamaan'      => 'bg-amber-500',
                                    'keamanan'       => 'bg-orange-500',
                                    'lainnya'        => 'bg-gray-400',
                                ];
                                $dot = $dotColors[$key] ?? 'bg-gray-400';
                            @endphp
                            <button type="button"
                                    @click="selected = '{{ $key }}'; label = '{{ $label }}'; open = false"
                                    :class="selected === '{{ $key }}' ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50'"
                                    class="w-full text-left px-3 py-2.5 text-sm rounded-lg transition-colors flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full shrink-0 {{ $dot }}"></span>
                                {{ $label }}
                                <svg x-show="selected === '{{ $key }}'" class="w-4 h-4 ml-auto text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @error('type')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-2">Status Publikasi</label>
                    <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg border border-gray-100 bg-gray-50 hover:bg-blue-50/50 hover:border-blue-200 transition-colors has-[:checked]:border-blue-300 has-[:checked]:bg-blue-50">
                        <div class="relative">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                            <div class="w-10 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-700">Tampilkan ke Publik</span>
                            <p class="text-xs text-gray-400">Lembaga terlihat di website</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Tombol Aksi Desktop --}}
            <div class="hidden lg:flex flex-col gap-3">
                <button type="submit" class="w-full px-5 py-3 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    Simpan Lembaga
                </button>
                <a href="{{ route('admin.institutions.index') }}" class="w-full px-5 py-3 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors text-center">
                    Batal
                </a>
            </div>
        </div>

        {{-- ── Kolom Utama ── --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Informasi Dasar --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-5 border-b border-gray-100 pb-3">Informasi Lembaga</h3>
                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nama Lembaga <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required maxlength="150"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Contoh: PKK Desa Sukamaju, Karang Taruna Muda Bersatu">
                        @error('name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-1">
                            Deskripsi <span class="text-gray-400 font-normal text-xs">(Opsional)</span>
                        </label>
                        <textarea name="description" id="description" rows="5"
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm resize-none"
                                  placeholder="Ceritakan tentang lembaga ini, tugas, visi, misi, atau informasi penting lainnya...">{{ old('description') }}</textarea>
                        @error('description')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="contact_person" class="block text-sm font-bold text-gray-700 mb-1">
                            Narahubung <span class="text-gray-400 font-normal text-xs">(Opsional)</span>
                        </label>
                        <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person') }}" maxlength="255"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Nama / No. HP / WhatsApp narahubung lembaga">
                        @error('contact_person')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Galeri Foto Lembaga --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6"
                 x-data="{ images: [] }">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Galeri Foto <span class="text-xs font-normal text-gray-400 ml-1">(Opsional)</span></h3>
                        <p class="text-xs text-gray-500 mt-0.5">Foto-foto kegiatan atau dokumentasi lembaga.</p>
                    </div>
                    <label class="inline-flex items-center gap-1.5 px-4 py-2 border text-sm font-semibold rounded-lg transition-colors cursor-pointer"
                           :class="images.length >= 5 ? 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-gray-100'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Foto
                        <input type="file" id="galleryInput" name="gallery[]" accept="image/*" multiple class="sr-only"
                               :disabled="images.length >= 5"
                               @change="
                                   let dt = new DataTransfer();
                                   images.forEach(img => dt.items.add(img.file));

                                   Array.from($event.target.files).forEach(f => {
                                       if (images.length >= 5) {
                                           alert('Maksimal 5 foto galeri!');
                                           return;
                                       }
                                       if (f.size > 2097152) {
                                           alert('Maks 2MB per file!');
                                           return;
                                       }
                                       let newImg = { id: Date.now() + Math.random(), preview: URL.createObjectURL(f), file: f };
                                       images.push(newImg);
                                       dt.items.add(f);
                                   });
                                   $event.target.files = dt.files;
                               ">
                    </label>
                </div>

                <div x-show="images.length === 0" class="text-center py-8 bg-gray-50/50 rounded-lg border border-dashed border-gray-200">
                    <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-sm text-gray-400">Belum ada foto. Klik "Tambah Foto" di atas.</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    <template x-for="(img, index) in images" :key="img.id">
                        <div class="relative group aspect-square rounded-xl overflow-hidden border border-gray-200 bg-gray-100">
                            <img :src="img.preview" class="w-full h-full object-cover">
                            <button type="button" @click="
                                        images.splice(index, 1);
                                        let dt = new DataTransfer();
                                        images.forEach(img => dt.items.add(img.file));
                                        document.getElementById('galleryInput').files = dt.files;
                                    "
                                    class="absolute top-1.5 right-1.5 w-7 h-7 bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-md hover:bg-red-700">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </template>
                </div>
                @error('gallery.*')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Anggota / Pengurus --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Pengurus / Anggota</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Susunan pengurus lembaga ini.</p>
                    </div>
                    <button type="button"
                            @click="members.push({ id: Date.now(), name: '', position: '', photoPreview: null })"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-50 border border-blue-200 text-blue-700 text-sm font-semibold rounded-lg hover:bg-blue-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Anggota
                    </button>
                </div>

                <div class="space-y-3">
                    <div x-show="members.length === 0" class="text-center py-8 bg-gray-50/50 rounded-lg border border-dashed border-gray-200">
                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <p class="text-sm text-gray-400">Belum ada pengurus. Klik "Tambah Anggota".</p>
                    </div>

                    <template x-for="(member, index) in members" :key="member.id">
                        <div class="flex items-start gap-3 p-4 bg-gray-50 border border-gray-200 rounded-xl hover:border-gray-300 transition-colors">
                            {{-- Foto mini --}}
                            <div class="shrink-0">
                                <div class="relative w-14 h-14 rounded-xl overflow-hidden border-2 border-dashed border-gray-300 bg-white hover:border-blue-400 transition-colors cursor-pointer flex items-center justify-center"
                                     @click="document.getElementById('mp_' + member.id).click()">
                                    <template x-if="member.photoPreview">
                                        <img :src="member.photoPreview" class="absolute inset-0 w-full h-full object-cover object-top">
                                    </template>
                                    <svg :class="{ 'opacity-0': member.photoPreview }" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <input type="file" :name="'members[' + index + '][photo]'" :id="'mp_' + member.id" accept="image/*" class="sr-only"
                                       @change="const f=$event.target.files[0]; if(f){if(f.size>2097152){alert('Maks 2MB!');return;}member.photoPreview=URL.createObjectURL(f);}">
                            </div>

                            {{-- Fields --}}
                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 mb-1">Nama <span class="text-red-500">*</span></label>
                                    <input type="text" :name="'members[' + index + '][name]'" required
                                           class="w-full px-3 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                                           placeholder="Nama anggota...">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 mb-1">Jabatan <span class="text-red-500">*</span></label>
                                    <input type="text" :name="'members[' + index + '][position]'" required
                                           class="w-full px-3 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                                           placeholder="Ketua, Sekretaris...">
                                </div>
                            </div>

                            {{-- Hapus --}}
                            <button type="button" @click="members.splice(index, 1)"
                                    class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors shrink-0 mt-5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

        </div>{{-- /Kolom Utama --}}
    </div>

    {{-- Tombol Aksi Mobile --}}
    <div class="mt-6 flex lg:hidden gap-3">
        <a href="{{ route('admin.institutions.index') }}" class="flex-1 px-4 py-3 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 text-center transition-colors">Batal</a>
        <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">Simpan Lembaga</button>
    </div>
</form>

<style>[x-cloak] { display: none !important; }</style>
@endsection
