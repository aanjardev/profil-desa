@extends('layouts.app')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
@endpush

@section('page_title', 'Edit Data UMKM')
@section('page_subtitle', 'Perbarui informasi detail mengenai UMKM unggulan desa.')

@section('content')
<form action="{{ route('admin.umkms.update', $umkm->id) }}" method="POST" enctype="multipart/form-data" 
      x-data="{ images: [] }">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Utama -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Dasar -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Informasi UMKM</h3>
                
                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nama UMKM <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $umkm->name) }}" required maxlength="255"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Contoh: Keripik Singkong Bu Sari">
                        @error('name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="category" class="block text-sm font-bold text-gray-700 mb-1">Kategori Usaha <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="category" id="category" value="{{ old('category', $umkm->category) }}" maxlength="100"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                                   placeholder="Contoh: Kuliner / Kerajinan / Fashion">
                            @error('category')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="owner_name" class="block text-sm font-bold text-gray-700 mb-1">Nama Pemilik <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name', $umkm->owner_name) }}" maxlength="255"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                                   placeholder="Contoh: Ibu Sari">
                            @error('owner_name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Usaha <span class="text-red-500">*</span></label>
                        <textarea name="description" id="description" rows="8" required
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                                  placeholder="Ceritakan produk/jasa, keunggulan, dan hal menarik dari UMKM ini...">{{ old('description', $umkm->description) }}</textarea>
                        @error('description')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="opening_hours" class="block text-sm font-bold text-gray-700 mb-1">Jam Operasional <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="text" name="opening_hours" id="opening_hours" value="{{ old('opening_hours', $umkm->opening_hours) }}" maxlength="255"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Contoh: Senin - Sabtu, 08:00 - 17:00 WIB">
                        @error('opening_hours')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Lokasi & Informasi Tambahan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Lokasi & Informasi Tambahan</h3>
                
                <div class="space-y-5">
                    <div>
                        <label for="location" class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="location" id="location" value="{{ old('location', $umkm->location) }}" required maxlength="255"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Contoh: Jl. Raya Desa No. 12, RT 01/RW 02">
                        @error('location')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="instagram_link" class="block text-sm font-bold text-gray-700 mb-1">Link Instagram <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="url" name="instagram_link" id="instagram_link" value="{{ old('instagram_link', $umkm->instagram_link) }}" maxlength="255"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                                   placeholder="https://instagram.com/...">
                            @error('instagram_link')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="youtube_link" class="block text-sm font-bold text-gray-700 mb-1">Link Youtube <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="url" name="youtube_link" id="youtube_link" value="{{ old('youtube_link', $umkm->youtube_link) }}" maxlength="255"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                                   placeholder="https://youtube.com/...">
                            @error('youtube_link')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="marketplace_link" class="block text-sm font-bold text-gray-700 mb-1">Link Marketplace / Order Online <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="url" name="marketplace_link" id="marketplace_link" value="{{ old('marketplace_link', $umkm->marketplace_link) }}" maxlength="255"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="https://shopee.co.id/... atau https://wa.me/...">
                        @error('marketplace_link')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="facilities" class="block text-sm font-bold text-gray-700 mb-1">Produk / Layanan Unggulan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <textarea name="facilities" id="facilities" rows="3"
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                                  placeholder="Contoh: Keripik Singkong Balado, Keripik Pisang Coklat, Kue Kering Lebaran">{{ old('facilities', $umkm->facilities) }}</textarea>
                        @error('facilities')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Samping (Media & Status) -->
        <div class="space-y-6">
            <!-- Publikasi -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Status Publikasi</h3>
                <div class="flex items-center">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $umkm->is_active) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-bold text-gray-700">Tampilkan ke Publik</span>
                    </label>
                </div>
                
                <div class="mt-5">
                    <label for="contact_person" class="block text-sm font-bold text-gray-700 mb-1">Kontak / Narahubung <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $umkm->contact_person) }}" maxlength="255"
                           class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                           placeholder="Nama / Nomor HP / WhatsApp">
                    @error('contact_person')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Thumbnail Utama -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" 
                 x-data="{ 
                    imageUrl: '{{ $umkm->main_image ? Storage::url($umkm->main_image) : null }}', 
                    showCropper: false, 
                    cropper: null,
                    initCropper() {
                        this.$watch('showCropper', value => {
                            if (value) {
                                this.$nextTick(() => {
                                    const image = document.getElementById('cropperImageUmkm');
                                    if(this.cropper) this.cropper.destroy();
                                    this.cropper = new Cropper(image, {
                                        aspectRatio: 16 / 9,
                                        viewMode: 1,
                                        dragMode: 'move',
                                        autoCropArea: 1,
                                    });
                                });
                            }
                        });
                    },
                    applyCrop() {
                        if(this.cropper) {
                            const canvas = this.cropper.getCroppedCanvas({
                                width: 1280,
                                height: 720
                            });
                            this.imageUrl = canvas.toDataURL('image/jpeg', 0.8);
                            document.getElementById('cropped_image_input').value = this.imageUrl;
                            this.showCropper = false;
                        }
                    }
                 }" x-init="initCropper()">
                 
                <input type="hidden" name="cropped_image" id="cropped_image_input">
                
                <div class="flex flex-col gap-1 mb-3 border-b border-gray-100 pb-3">
                    <h3 class="text-base font-bold text-gray-900">Gambar Utama (Thumbnail)</h3>
                    <p class="text-[11px] text-gray-500 leading-tight">Biarkan jika tidak ingin mengganti gambar. Akan di-crop ke <span class="font-bold">16:9</span>. Maksimal <span class="font-bold">2MB</span>.</p>
                </div>
                
                <div class="mt-1 flex flex-col justify-center items-center w-full aspect-video border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 hover:bg-blue-50 transition-colors relative overflow-hidden group">
                    <!-- Preview Image -->
                    <template x-if="imageUrl">
                        <div class="absolute inset-0 w-full h-full">
                            <img :src="imageUrl" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity gap-2">
                                <label class="cursor-pointer text-white text-sm font-medium bg-black/50 px-3 py-1 rounded-md hover:bg-black/70">
                                    Ganti
                                    <input type="file" class="sr-only" accept="image/*"
                                           @change="const file = $event.target.files[0]; if (file) { if(file.size > 2097152) { alert('Ukuran maksimal 2MB!'); $event.target.value = ''; return; } const reader = new FileReader(); reader.onload = (e) => { document.getElementById('cropperImageUmkm').src = e.target.result; showCropper = true; }; reader.readAsDataURL(file); }">
                                </label>
                            </div>
                        </div>
                    </template>

                    <div class="space-y-2 text-center relative z-10" :class="{'opacity-0 hover:opacity-100': imageUrl}">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-3">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none px-2 py-1 shadow-sm border border-gray-200">
                                <span>Pilih gambar</span>
                                <input type="file" class="sr-only" accept="image/*"
                                       @change="const file = $event.target.files[0]; if (file) { if(file.size > 2097152) { alert('Ukuran maksimal 2MB!'); $event.target.value = ''; return; } const reader = new FileReader(); reader.onload = (e) => { document.getElementById('cropperImageUmkm').src = e.target.result; showCropper = true; }; reader.readAsDataURL(file); }">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, WEBP maks 2MB</p>
                    </div>
                </div>
                @error('cropped_image')<p class="mt-2 text-sm text-red-500">{{ $message }}</p>@enderror

                <!-- Modal Cropper -->
                <div x-show="showCropper" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" x-cloak>
                    <div class="bg-white rounded-xl shadow-2xl overflow-hidden w-full max-w-2xl flex flex-col max-h-[90vh]">
                        <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                            <h3 class="font-bold text-gray-800">Atur Potongan Thumbnail</h3>
                            <button type="button" @click="showCropper = false" class="text-gray-400 hover:text-gray-600 p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="p-4 bg-gray-900 flex-1 overflow-hidden min-h-[400px]">
                            <img id="cropperImageUmkm" class="max-w-full block">
                        </div>
                        <div class="p-4 border-t border-gray-100 bg-white flex justify-end gap-3">
                            <button type="button" @click="showCropper = false" class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Batal</button>
                            <button type="button" @click="applyCrop()" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">Terapkan Potongan</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tombol Aksi (Desktop) -->
            <div class="hidden lg:flex justify-end gap-3">
                <a href="{{ route('admin.umkms.index') }}" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">Simpan Perubahan</button>
            </div>
        </div>
    </div>

    <!-- Galeri / Gambar Pendukung (Multi-Upload) -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 border-b border-gray-100 pb-4 gap-4">
            <div>
                <h3 class="text-base font-bold text-gray-900">Galeri Pendukung <span class="text-[10px] uppercase font-bold tracking-wider text-gray-400 bg-gray-100 px-2 py-0.5 rounded ml-2">Opsional</span></h3>
                <p class="text-xs text-gray-500 mt-1">Tambahkan foto produk atau dokumentasi usaha. <span class="font-medium text-gray-700">Rasio gambar bebas, maksimal 2MB per file.</span></p>
            </div>
            <button type="button" @click="images.push({ id: Date.now(), preview: null })" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Gambar Galeri
            </button>
        </div>

        <div class="space-y-4">
            @if($umkm->supporting_images)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($umkm->supporting_images as $index => $img)
                    <div class="relative flex flex-col items-start gap-4 p-4 bg-gray-50 border border-gray-200 rounded-xl group transition-all" x-data="{ deleted: false }" x-show="!deleted">
                        <!-- Checkbox untuk delete via backend -->
                        <input type="checkbox" name="delete_images[]" value="{{ $index }}" class="sr-only" x-model="deleted">
                        
                        <div class="w-full aspect-video rounded-lg overflow-hidden relative border border-gray-200 bg-black/5">
                            <img src="{{ Storage::url($img['path']) }}" class="absolute inset-0 w-full h-full object-cover">
                        </div>
                        <div class="w-full flex justify-between items-start gap-2">
                            <div class="flex-1">
                                <span class="block text-xs font-bold text-gray-600 mb-1">Keterangan:</span>
                                <p class="text-sm text-gray-800">{{ $img['caption'] ?? '-' }}</p>
                            </div>
                            <button type="button" @click="deleted = true" class="shrink-0 text-sm font-semibold text-red-500 hover:text-red-700 flex items-center gap-1 bg-red-50 px-3 py-1.5 rounded-lg transition-colors" title="Hapus foto ini">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                @endforeach
                </div>
            @endif

            <!-- List Input Gambar Dinamis (Baru) -->
            <template x-for="(img, index) in images" :key="img.id">
                <div class="relative flex flex-col md:flex-row items-start gap-4 p-4 bg-blue-50/50 border border-blue-100 rounded-xl group transition-all hover:border-blue-300 hover:shadow-sm">
                    
                    <!-- File Input & Preview -->
                    <div class="w-full md:w-48 shrink-0 relative aspect-video rounded-lg border-2 border-dashed border-blue-300 bg-white flex items-center justify-center overflow-hidden hover:border-blue-400 transition-colors"
                         :class="{'border-solid border-transparent': img.preview}">
                        
                        <template x-if="img.preview">
                            <img :src="img.preview" class="absolute inset-0 w-full h-full object-cover">
                        </template>

                        <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/5 opacity-0 hover:opacity-100 transition-opacity"
                             :class="{'opacity-100 bg-transparent': !img.preview, 'bg-black/40': img.preview}">
                            <label class="cursor-pointer flex flex-col items-center justify-center w-full h-full">
                                <span class="bg-white/90 text-gray-700 text-xs font-bold px-3 py-1.5 rounded-md shadow-sm" x-text="img.preview ? 'Ganti' : 'Pilih File'"></span>
                                <input type="file" :name="'supporting_images['+index+'][file]'" class="sr-only" accept="image/*" required
                                       @change="const file = $event.target.files[0]; if (file) { if(file.size > 2097152) { alert('Maksimal 2MB!'); $event.target.value = ''; return; } img.preview = URL.createObjectURL(file); }">
                            </label>
                        </div>
                    </div>

                    <!-- Caption Input -->
                    <div class="flex-1 w-full flex flex-col justify-between h-full space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-blue-800 mb-1">Keterangan Foto Baru (Opsional)</label>
                            <input type="text" :name="'supporting_images['+index+'][caption]'" maxlength="500"
                                   class="w-full px-4 py-2 bg-white border border-blue-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                                   placeholder="Contoh: Produk unggulan keripik balado...">
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="button" @click="images.splice(index, 1)" class="text-sm font-semibold text-red-500 hover:text-red-700 flex items-center gap-1 bg-white border border-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Tombol Aksi (Mobile) -->
    <div class="mt-6 flex lg:hidden gap-3">
        <a href="{{ route('admin.umkms.index') }}" class="flex-1 px-4 py-3 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 text-center transition-colors">Batal</a>
        <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">Simpan Perubahan</button>
    </div>
</form>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
