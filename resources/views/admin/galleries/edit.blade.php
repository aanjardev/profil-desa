@extends('layouts.app')

@section('page_title', 'Edit Gambar Galeri')
@section('page_subtitle', 'Perbarui detail gambar atau ganti gambar pada galeri dokumentasi desa.')

@section('content')

<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
        
        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-bold text-red-800 mb-1">Terdapat kesalahan:</h4>
                    <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex items-center gap-3 text-red-700">
            <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium text-sm">{{ session('error') }}</span>
        </div>
        @endif

        <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                
                <!-- Upload Area -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Ganti Gambar <span class="text-gray-400 font-normal ml-1">(Opsional)</span></label>
                    
                    <div class="relative group cursor-pointer">
                        <input type="file" name="image" id="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewImage(this)">
                        
                        <div id="upload-placeholder" class="hidden border-2 border-dashed border-gray-300 rounded-xl p-8 flex-col items-center justify-center text-center bg-gray-50 group-hover:bg-blue-50 group-hover:border-blue-300 transition-colors">
                            <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center mb-3 text-gray-400 group-hover:text-blue-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-700 mb-1 group-hover:text-blue-700">Klik atau drag gambar ke sini untuk mengganti</p>
                            <p class="text-xs text-gray-500">Format JPG, PNG, WEBP.</p>
                            
                            <div class="mt-4 inline-flex items-center gap-2 bg-yellow-50 border border-yellow-200 text-yellow-800 text-[11px] font-medium px-3 py-1.5 rounded-lg">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Rekomendasi: Rasio 16:9 (Landscape) • Maksimal 2MB
                            </div>
                        </div>

                        <!-- Preview Area -->
                        <div id="image-preview-container" class="relative rounded-xl overflow-hidden border border-gray-200 bg-gray-100 aspect-video w-full flex items-center justify-center">
                            <img id="image-preview" src="{{ str_starts_with($gallery->image_path, 'images/') ? asset($gallery->image_path) : asset('storage/' . $gallery->image_path) }}" alt="Preview" class="w-full h-full object-contain">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                                <span class="text-white text-sm font-semibold px-4 py-2 bg-black/50 rounded-lg backdrop-blur-sm">Klik untuk mengganti gambar</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Error Message Container -->
                    <p id="image-error" class="text-sm font-semibold text-red-600 mt-2 hidden flex items-center gap-1.5">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Ukuran file melebihi batas maksimal 2MB. Silakan perkecil ukuran gambar Anda sebelum mengunggah.</span>
                    </p>
                    
                    <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika Anda tidak ingin mengganti gambar saat ini.</p>
                </div>

                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Judul Gambar <span class="text-gray-400 font-normal ml-1">(Opsional)</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $gallery->title) }}" placeholder="Contoh: Kegiatan Kerja Bakti Warga" 
                           maxlength="100"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat <span class="text-gray-400 font-normal ml-1">(Opsional)</span></label>
                    <textarea name="description" id="description" rows="3" placeholder="Tuliskan keterangan singkat mengenai gambar ini..."
                              maxlength="500"
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm resize-none">{{ old('description', $gallery->description) }}</textarea>
                </div>

            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.galleries.index') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-900 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');
        const errorMsg = document.getElementById('image-error');
        
        // Sembunyikan error sebelumnya
        errorMsg.classList.add('hidden');
        
        if (input.files && input.files[0]) {
            // Check file size (max 2MB)
            if (input.files[0].size > 2 * 1024 * 1024) {
                // Tampilkan pesan error
                errorMsg.classList.remove('hidden');
                
                // Reset input file agar tidak terkirim
                input.value = '';
                
                // Pada halaman edit, jika upload dibatalkan karena terlalu besar,
                // biarkan preview gambar lama tetap terlihat (karena tidak jadi diganti)
                return; 
            }

            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
                previewContainer.classList.add('flex');
                
                placeholder.classList.add('hidden');
                placeholder.classList.remove('flex');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
