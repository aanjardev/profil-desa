@extends('layouts.app')

@section('page_title', 'Edit ' . $identity->title)
@section('page_subtitle', 'Ubah judul dan isi narasi profil desa.')

@section('content')
<form action="{{ route('admin.village-identities.update', $identity->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
    @csrf
    @method('PUT')
    
    <div class="p-6 md:p-8 space-y-6">
        <div>
            <h3 class="text-base font-bold text-gray-900 mb-4 pb-2 border-b flex items-center gap-2">
                <span class="w-1.5 h-4 bg-blue-600 rounded-full"></span>
                Form Konten Profil
            </h3>
            
            <div class="space-y-6">
                <!-- Judul Profil -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul Profil</label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $identity->title) }}" 
                           class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" 
                           required 
                           autofocus 
                           maxlength="255">
                    @error('title') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Gambar Opsional -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar Pelengkap (Opsional)</label>
                    @if($identity->image_url)
                        <div class="mb-3">
                            <img src="{{ $identity->image_url }}" alt="Gambar {{ $identity->title }}" class="h-32 object-cover rounded-lg border">
                            <div class="mt-2 flex items-center gap-2">
                                <input type="checkbox" name="remove_image" id="remove_image" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                <label for="remove_image" class="text-sm text-red-600">Hapus gambar ini</label>
                            </div>
                        </div>
                    @endif
                    <input type="file" name="image_file" accept="image/png,image/jpeg,image/jpg" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <span class="text-[11px] text-gray-400 mt-1 block">Format: JPG, PNG (Maks. 2MB). Biarkan kosong jika tidak ingin mengubah.</span>
                    @error('image_file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Isi Konten -->
                <div>
                    <label for="content" class="block text-sm font-semibold text-gray-700 mb-1">Isi Narasi Konten</label>
                    <textarea id="content" 
                              name="content" 
                              rows="12" 
                              class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm leading-relaxed" 
                              required>{{ old('content', $identity->content) }}</textarea>
                    <span class="text-[11px] text-gray-400 mt-1 block">Tuliskan narasi lengkap untuk bagian ini. Gunakan baris baru (Enter) untuk membagi paragraf agar terlihat rapi.</span>
                    @error('content') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
        <a href="{{ route('admin.village-identities.index') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-2 px-6 rounded-lg transition-colors text-sm flex items-center">
            Batal
        </a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-sm transition-colors text-sm">
            Simpan Perubahan
        </button>
    </div>
</form>
@endsection
