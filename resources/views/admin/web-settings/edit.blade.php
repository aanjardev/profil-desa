@extends('layouts.app')

@section('page_title', 'Edit Info Web')
@section('page_subtitle', 'Ubah identitas, alamat, kontak, dan branding website desa.')

@section('content')

<form action="{{ route('admin.web-settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
    @csrf
    @method('PUT')
    
    <div class="p-6 md:p-8 space-y-8">
        
        <!-- Identitas Utama & Branding -->
        <div>
            <h3 class="text-base font-bold text-gray-900 mb-4 pb-2 border-b flex items-center gap-2">
                <span class="w-1.5 h-4 bg-blue-600 rounded-full"></span>
                Identitas & Branding
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Desa</label>
                    <input type="text" name="village_name" value="{{ old('village_name', $webSetting->village_name) }}" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" required autofocus maxlength="100">
                    @error('village_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Logo Desa</label>
                    <input type="file" name="logo_file" accept="image/png,image/jpeg,image/jpg,image/svg+xml" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <span class="text-[11px] text-gray-400 mt-1 block">Format: JPG, PNG, SVG (Maks. 2MB). Kosongkan jika tidak ingin mengubah.</span>
                    @error('logo_file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Favicon Desa (Tab Browser)</label>
                    <input type="file" name="favicon_file" accept="image/png,image/jpeg,image/jpg,image/svg+xml,image/x-icon" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <span class="text-[11px] text-gray-400 mt-1 block">Format: ICO, PNG, SVG (Maks. 1MB). Kosongkan jika tidak ingin mengubah.</span>
                    @error('favicon_file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Wilayah & Alamat -->
        <div>
            <h3 class="text-base font-bold text-gray-900 mb-4 pb-2 border-b flex items-center gap-2">
                <span class="w-1.5 h-4 bg-blue-600 rounded-full"></span>
                Wilayah & Alamat
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kecamatan</label>
                    <input type="text" name="subdistrict" value="{{ old('subdistrict', $webSetting->subdistrict) }}" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" maxlength="100">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kabupaten/Kota</label>
                    <input type="text" name="city" value="{{ old('city', $webSetting->city) }}" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" maxlength="100">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Provinsi</label>
                    <input type="text" name="province" value="{{ old('province', $webSetting->province) }}" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" maxlength="100">
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea name="address" rows="3" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm">{{ old('address', $webSetting->address) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Embed Google Maps (&lt;iframe&gt;)</label>
                <textarea name="maps_embed" rows="3" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Copy-paste tag <iframe> dari Google Maps">{{ old('maps_embed', $webSetting->maps_embed) }}</textarea>
                <span class="text-[11px] text-gray-400 mt-1 block">Salin kode HTML dari Google Maps melalui menu Bagikan > Sematkan Peta.</span>
            </div>
        </div>

        <!-- Kontak & Media Sosial -->
        <div>
            <h3 class="text-base font-bold text-gray-900 mb-4 pb-2 border-b flex items-center gap-2">
                <span class="w-1.5 h-4 bg-blue-600 rounded-full"></span>
                Kontak & Media Sosial
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                    <input type="tel" name="phone" value="{{ old('phone', $webSetting->phone) }}" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" maxlength="20" pattern="[0-9+\s\-]*">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Desa</label>
                    <input type="email" name="email" value="{{ old('email', $webSetting->email) }}" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" maxlength="100">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">URL Facebook</label>
                    <input type="url" name="facebook" value="{{ old('facebook', $webSetting->facebook) }}" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="https://facebook.com/nama-desa" maxlength="255">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">URL Instagram</label>
                    <input type="url" name="instagram" value="{{ old('instagram', $webSetting->instagram) }}" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="https://instagram.com/nama-desa" maxlength="255">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">URL Youtube</label>
                    <input type="url" name="youtube" value="{{ old('youtube', $webSetting->youtube) }}" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="https://youtube.com/channel/nama-desa" maxlength="255">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">URL Twitter</label>
                    <input type="url" name="twitter" value="{{ old('twitter', $webSetting->twitter) }}" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="https://twitter.com/nama-desa" maxlength="255">
                </div>
            </div>
        </div>

    </div>

    <!-- Actions -->
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
        <a href="{{ route('admin.web-settings.show') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-2 px-6 rounded-lg transition-colors text-sm flex items-center">
            Batal
        </a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-sm transition-colors text-sm">
            Simpan Perubahan
        </button>
    </div>
</form>
@endsection
