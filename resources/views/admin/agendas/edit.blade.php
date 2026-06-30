@extends('layouts.app')

@section('page_title', 'Edit Agenda')
@section('page_subtitle', 'Perbarui informasi acara atau kegiatan desa.')

@section('content')
<form action="{{ route('admin.agendas.update', $agenda->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Informasi Acara</h3>
                
                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="title" class="block text-sm font-bold text-gray-700 mb-1">Judul Acara <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $agenda->title) }}" required maxlength="255"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                                   placeholder="Contoh: Kerja Bakti Bersih Desa">
                            @error('title')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-bold text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                            <select name="category" id="category" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                                <option value="Pemerintahan" {{ old('category', $agenda->category) == 'Pemerintahan' ? 'selected' : '' }}>Pemerintahan</option>
                                <option value="Pembangunan" {{ old('category', $agenda->category) == 'Pembangunan' ? 'selected' : '' }}>Pembangunan</option>
                                <option value="Sosial" {{ old('category', $agenda->category) == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                                <option value="Kesehatan" {{ old('category', $agenda->category) == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                <option value="Pendidikan" {{ old('category', $agenda->category) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                <option value="Kebudayaan" {{ old('category', $agenda->category) == 'Kebudayaan' ? 'selected' : '' }}>Kebudayaan</option>
                                <option value="Lainnya" {{ old('category', $agenda->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('category')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="description" id="description" rows="5" required
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                                  placeholder="Deskripsikan tentang acara ini...">{{ old('description', $agenda->description) }}</textarea>
                        @error('description')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="audience" class="block text-sm font-bold text-gray-700 mb-1">Target Audiens</label>
                            <input type="text" name="audience" id="audience" value="{{ old('audience', $agenda->audience) }}" maxlength="255"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                                   placeholder="Contoh: Umum, Ibu-ibu, Perangkat Desa">
                            @error('audience')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="organizer" class="block text-sm font-bold text-gray-700 mb-1">Penyelenggara</label>
                            <input type="text" name="organizer" id="organizer" value="{{ old('organizer', $agenda->organizer) }}" maxlength="255"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                                   placeholder="Contoh: Pemerintah Desa, Karang Taruna">
                            @error('organizer')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Waktu & Tempat</h3>
                
                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="start_date" class="block text-sm font-bold text-gray-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $agenda->start_date) }}" required
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                            @error('start_date')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-bold text-gray-700 mb-1">Tanggal Selesai (Opsional)</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $agenda->end_date) }}"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                            @error('end_date')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="start_time" class="block text-sm font-bold text-gray-700 mb-1">Jam Mulai (Opsional)</label>
                            <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $agenda->start_time) }}"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                            @error('start_time')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-bold text-gray-700 mb-1">Jam Selesai (Opsional)</label>
                            <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $agenda->end_time) }}"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                            @error('end_time')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-bold text-gray-700 mb-1">Lokasi Acara <span class="text-red-500">*</span></label>
                        <input type="text" name="location" id="location" value="{{ old('location', $agenda->location) }}" required maxlength="255"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Contoh: Balai Desa">
                        @error('location')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="maps_link" class="block text-sm font-bold text-gray-700 mb-1">Link Google Maps (Opsional)</label>
                        <input type="url" name="maps_link" id="maps_link" value="{{ old('maps_link', $agenda->maps_link) }}" maxlength="255"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="https://maps.google.com/...">
                        @error('maps_link')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Status</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-bold text-gray-700 mb-1">Status Publikasi</label>
                        <select name="status" id="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                            <option value="published" {{ old('status', $agenda->status) == 'published' ? 'selected' : '' }}>Dipublikasikan</option>
                            <option value="draft" {{ old('status', $agenda->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="cancelled" {{ old('status', $agenda->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $agenda->is_active) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-bold text-gray-700">Tampilkan ke Publik (Aktif)</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Kontak</h3>
                <div>
                    <label for="contact_person" class="block text-sm font-bold text-gray-700 mb-1">Narahubung (Opsional)</label>
                    <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $agenda->contact_person) }}" maxlength="255"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                           placeholder="Nama / Nomor HP">
                    @error('contact_person')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="hidden lg:flex justify-end gap-3">
                <a href="{{ route('admin.agendas.index') }}" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">Simpan Perubahan</button>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi (Mobile) -->
    <div class="mt-6 flex lg:hidden gap-3">
        <a href="{{ route('admin.agendas.index') }}" class="flex-1 px-4 py-3 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 text-center transition-colors">Batal</a>
        <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">Simpan Perubahan</button>
    </div>
</form>
@endsection
