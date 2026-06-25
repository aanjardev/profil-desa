@extends('layouts.app')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
@endpush

@section('page_title', 'Edit Artikel')
@section('page_subtitle', 'Perbarui informasi, pengumuman, atau agenda kegiatan desa.')

@section('content')
<form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" 
      x-data="{ category: '{{ old('category', $post->category) }}', newImages: [], existingImages: {{ $post->images->map(function($img) { return ['id' => $img->id, 'url' => asset('storage/'.$img->image_path), 'caption' => $img->caption]; })->toJson() }}, deletedImages: [] }">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Utama -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Dasar -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Informasi Dasar</h3>
                
                <div class="space-y-5">
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-1">Judul Artikel <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required maxlength="255"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Contoh: Pembagian BLT Bulan Juni">
                        @error('title')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="w-full md:w-1/2">
                        <div class="relative" x-data="{ openCat: false }">
                            <label for="category" class="block text-sm font-bold text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                            <input type="hidden" name="category" :value="category">
                            <button type="button" @click="openCat = !openCat" @click.away="openCat = false"
                                    class="w-full flex items-center justify-between px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                                <span x-text="category"></span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': openCat}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="openCat" x-transition.opacity.duration.200ms style="display: none;"
                                 class="absolute z-30 mt-2 w-full max-h-60 overflow-y-auto bg-white border border-gray-100 rounded-lg shadow-lg py-1">
                                <template x-for="catOption in ['Pemerintahan', 'Pembangunan', 'Pendidikan', 'Kesehatan', 'Ekonomi', 'Pariwisata', 'Sosial', 'Lainnya']" :key="catOption">
                                    <button type="button" @click="category = catOption; openCat = false" class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors" :class="category === catOption ? 'font-bold text-blue-600 bg-blue-50/50' : 'text-gray-700'" x-text="catOption"></button>
                                </template>
                            </div>
                            @error('category')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="content" class="block text-sm font-bold text-gray-700">Isi Konten <span class="text-red-500">*</span></label>
                            <span class="text-[11px] text-gray-400 bg-gray-100 px-2 py-0.5 rounded font-medium">Mendukung Markdown</span>
                        </div>
                        <textarea name="content" id="content" rows="12" required maxlength="10000"
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                                  placeholder="Tulis isi artikel secara detail di sini...">{{ old('content', $post->content) }}</textarea>
                        @error('content')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="tags" class="block text-sm font-bold text-gray-700">Tags / Kata Kunci (SEO)</label>
                            <span class="text-[10px] text-gray-400 bg-gray-100 px-2 py-0.5 rounded font-medium">Opsional</span>
                        </div>
                        <input type="text" name="tags" id="tags" value="{{ old('tags', $post->tags) }}" maxlength="500"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Contoh: BLT, bantuan sosial, desa mandiri (pisahkan dengan koma)">
                        <p class="text-xs text-gray-500 mt-1.5">Kata kunci membantu artikel ini lebih mudah ditemukan di mesin pencari (Google).</p>
                        @error('tags')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
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
                        <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-bold text-gray-700">Tampilkan ke Publik</span>
                    </label>
                </div>
            </div>

            <!-- Thumbnail Utama -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" 
                 x-data="{ 
                    imageUrl: '{{ $post->image ? asset('storage/' . $post->image) : '' }}', 
                    showCropper: false, 
                    cropper: null,
                    initCropper() {
                        this.$watch('showCropper', value => {
                            if (value) {
                                this.$nextTick(() => {
                                    const image = document.getElementById('cropperImage');
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

                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-base font-bold text-gray-900">Thumbnail Utama</h3>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-gray-400 bg-gray-100 px-2 py-0.5 rounded">Opsional</span>
                </div>
                
                <div class="mt-1 flex flex-col justify-center items-center w-full aspect-video border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 hover:bg-blue-50 transition-colors relative overflow-hidden group">
                    <!-- Preview Image -->
                    <template x-if="imageUrl">
                        <div class="absolute inset-0 w-full h-full">
                            <img :src="imageUrl" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity gap-2">
                                <label class="cursor-pointer text-white text-sm font-medium bg-black/50 px-3 py-1 rounded-md hover:bg-black/70">
                                    Ganti Baru
                                    <input type="file" class="sr-only" accept="image/*"
                                           @change="const file = $event.target.files[0]; if (file) { if(file.size > 2097152) { Swal.fire({icon: 'error', title: 'Oops...', text: 'Ukuran maksimal 2MB!'}); $event.target.value = ''; return; } const reader = new FileReader(); reader.onload = (e) => { document.getElementById('cropperImage').src = e.target.result; showCropper = true; }; reader.readAsDataURL(file); }">
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
                                <span>Pilih gambar baru</span>
                                <input type="file" class="sr-only" accept="image/*"
                                       @change="const file = $event.target.files[0]; if (file) { if(file.size > 2097152) { Swal.fire({icon: 'error', title: 'Oops...', text: 'Ukuran maksimal 2MB!'}); $event.target.value = ''; return; } const reader = new FileReader(); reader.onload = (e) => { document.getElementById('cropperImage').src = e.target.result; showCropper = true; }; reader.readAsDataURL(file); }">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, WEBP maksimal 2MB</p>
                    </div>
                </div>
                @error('image')<p class="mt-2 text-sm text-red-500">{{ $message }}</p>@enderror

                <!-- Modal Cropper -->
                <div x-show="showCropper" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" x-cloak>
                    <div class="bg-white rounded-xl shadow-2xl overflow-hidden w-full max-w-2xl flex flex-col max-h-[90vh]">
                        <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                            <h3 class="font-bold text-gray-800">Atur Potongan Thumbnail</h3>
                            <button type="button" @click="showCropper = false" class="text-gray-400 hover:text-gray-600 p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="p-4 bg-gray-900 flex-1 overflow-hidden min-h-[400px]">
                            <img id="cropperImage" class="max-w-full block">
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
                <a href="{{ route('admin.posts.index') }}" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">Simpan Perubahan</button>
            </div>
        </div>
    </div>

    <!-- Gambar Pendukung (Multi-Upload) -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 border-b border-gray-100 pb-4 gap-4">
            <div>
                <h3 class="text-base font-bold text-gray-900">Gambar Pendukung <span class="text-[10px] uppercase font-bold tracking-wider text-gray-400 bg-gray-100 px-2 py-0.5 rounded ml-2">Opsional</span></h3>
                <p class="text-xs text-gray-500 mt-1">Tambahkan atau hapus foto tambahan untuk melengkapi artikel ini. <span class="font-medium text-gray-700">Rasio gambar bebas (bebas potong).</span></p>
            </div>
            <button type="button" @click="newImages.push({ id: Date.now(), preview: null })" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Gambar Baru
            </button>
        </div>

        <div class="space-y-4">
            
            <!-- List Hidden Input untuk Gambar yang akan dihapus -->
            <template x-for="deletedId in deletedImages" :key="'del-'+deletedId">
                <input type="hidden" name="delete_images[]" :value="deletedId">
            </template>

            <!-- State Kosong Keseluruhan -->
            <div x-show="existingImages.length === 0 && newImages.length === 0" class="text-center py-8 bg-gray-50/50 rounded-lg border border-dashed border-gray-200">
                <p class="text-sm text-gray-500">Belum ada gambar pendukung. Klik tombol "Tambah Gambar Baru" untuk menambahkan.</p>
            </div>

            <!-- List Gambar Exist (Sudah ada di DB) -->
            <template x-for="(img, index) in existingImages" :key="img.id">
                <div class="relative flex flex-col md:flex-row items-start gap-4 p-4 bg-gray-50 border border-gray-200 rounded-xl group transition-all hover:border-blue-300 hover:shadow-sm">
                    
                    <div class="w-full md:w-48 shrink-0 relative aspect-video rounded-lg border-2 border-transparent bg-white flex items-center justify-center overflow-hidden">
                        <img :src="img.url" class="absolute inset-0 w-full h-full object-cover">
                        <!-- Lencana Existing -->
                        <span class="absolute top-2 left-2 bg-black/60 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider backdrop-blur-sm">Tersimpan</span>
                    </div>

                    <div class="flex-1 w-full flex flex-col justify-between h-full space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Deskripsi Gambar Saat Ini</label>
                            <input type="text" disabled :value="img.caption"
                                   class="w-full px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg text-sm text-gray-500"
                                   placeholder="Tidak ada deskripsi.">
                            <p class="text-[10px] text-gray-400 mt-1">Deskripsi gambar yang sudah ada tidak dapat diubah. Hapus dan upload ulang jika ingin mengganti.</p>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="button" @click="deletedImages.push(img.id); existingImages.splice(index, 1)" class="text-sm font-semibold text-red-500 hover:text-red-700 flex items-center gap-1 bg-red-50 px-3 py-1.5 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus Gambar
                            </button>
                        </div>
                    </div>
                </div>
            </template>

            <!-- List Input Gambar Baru (Dinamis) -->
            <template x-for="(img, index) in newImages" :key="img.id">
                <div class="relative flex flex-col md:flex-row items-start gap-4 p-4 bg-blue-50/30 border border-blue-200 rounded-xl group transition-all hover:border-blue-400 hover:shadow-sm">
                    
                    <!-- File Input & Preview -->
                    <div class="w-full md:w-48 shrink-0 relative aspect-video rounded-lg border-2 border-dashed border-blue-300 bg-white flex items-center justify-center overflow-hidden hover:border-blue-400 transition-colors"
                         :class="{'border-solid border-transparent': img.preview}">
                        
                        <template x-if="img.preview">
                            <img :src="img.preview" class="absolute inset-0 w-full h-full object-cover">
                        </template>

                        <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/5 opacity-0 hover:opacity-100 transition-opacity"
                             :class="{'opacity-100 bg-transparent': !img.preview, 'bg-black/40': img.preview}">
                            <label class="cursor-pointer flex flex-col items-center justify-center w-full h-full">
                                <span class="bg-white/90 text-gray-700 text-xs font-bold px-3 py-1.5 rounded-md shadow-sm" x-text="img.preview ? 'Ganti' : 'Pilih File Baru'"></span>
                                <input type="file" :name="'supporting_images['+index+'][file]'" class="sr-only" accept="image/*" required
                                       @change="const file = $event.target.files[0]; if (file) { if(file.size > 2097152) { Swal.fire({icon: 'error', title: 'Oops...', text: 'Maksimal 2MB!'}); $event.target.value = ''; return; } img.preview = URL.createObjectURL(file); }">
                            </label>
                        </div>
                    </div>

                    <!-- Caption Input -->
                    <div class="flex-1 w-full flex flex-col justify-between h-full space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Deskripsi Gambar (Opsional)</label>
                            <input type="text" :name="'supporting_images['+index+'][caption]'" maxlength="500"
                                   class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                                   placeholder="Tulis keterangan untuk gambar baru ini...">
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="button" @click="newImages.splice(index, 1)" class="text-sm font-semibold text-red-500 hover:text-red-700 flex items-center gap-1 bg-red-50 px-3 py-1.5 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
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
        <a href="{{ route('admin.posts.index') }}" class="flex-1 px-4 py-3 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 text-center transition-colors">Batal</a>
        <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">Simpan Perubahan</button>
    </div>
</form>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
