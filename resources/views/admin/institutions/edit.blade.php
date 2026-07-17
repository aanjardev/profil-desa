@extends('layouts.app')

@section('page_title', 'Edit Lembaga Desa')
@section('page_subtitle', 'Perbarui data lembaga dan susunan pengurusnya.')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
@endpush

@section('content')
<form action="{{ route('admin.institutions.update', $institution->id) }}" method="POST" enctype="multipart/form-data"
      x-data="{
          removeLogo: false,
          logoPreview: '{{ $institution->logo ? asset('storage/' . $institution->logo) : '' }}',
          members: [
              @foreach($institution->members as $member)
              {
                  id: {{ $member->id }},
                  dbId: {{ $member->id }},
                  name: '{{ addslashes($member->name) }}',
                  position: '{{ addslashes($member->position) }}',
                  photoPreview: '{{ $member->photo ? asset('storage/' . $member->photo) : '' }}',
                  removePhoto: false,
                  orderNum: {{ $member->order_num ?? 0 }},
                  isNew: false,
              },
              @endforeach
          ],
          deletedMemberIds: [],
          removeMember(index) {
              const m = this.members[index];
              if (m.dbId) this.deletedMemberIds.push(m.dbId);
              this.members.splice(index, 1);
          },
          deletedImages: [],
          showCropper: false,
          cropper: null,
          currentMemberIndex: null,
          initCropper() {
              this.$watch('showCropper', value => {
                  if (value) {
                      this.$nextTick(() => {
                          const image = document.getElementById('cropperImage');
                          if(this.cropper) this.cropper.destroy();
                          this.cropper = new Cropper(image, {
                              aspectRatio: 1,
                              viewMode: 1,
                              dragMode: 'move',
                              autoCropArea: 1,
                          });
                      });
                  }
              });
          },
          applyCrop() {
              if(this.cropper && this.currentMemberIndex !== null) {
                  const canvas = this.cropper.getCroppedCanvas({
                      width: 500,
                      height: 500
                  });
                  canvas.toBlob((blob) => {
                      let file = new File([blob], 'photo.jpg', { type: 'image/jpeg', lastModified: new Date().getTime() });
                      let container = new DataTransfer();
                      container.items.add(file);
                      let member = this.members[this.currentMemberIndex];
                      let input = document.getElementById('ep_' + member.id);
                      input.files = container.files;
                      member.photoPreview = URL.createObjectURL(file);
                      member.removePhoto = false;
                      this.showCropper = false;
                      this.currentMemberIndex = null;
                  }, 'image/jpeg');
              }
          }
      }" x-init="initCropper()">
    @csrf
    @method('PUT')
    <input type="hidden" name="remove_logo" :value="removeLogo ? '1' : '0'">
    <template x-for="mid in deletedMemberIds" :key="mid">
        <input type="hidden" name="delete_member_ids[]" :value="mid">
    </template>
    <template x-for="idx in deletedImages" :key="idx">
        <input type="hidden" name="delete_images[]" :value="idx">
    </template>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Kolom Kanan: Sidebar ── --}}
        <div class="space-y-6">

            {{-- Logo + Kategori + Status dalam satu kartu --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Logo & Status</h3>

                {{-- Logo compact --}}
                <div class="mb-5">
                    <label class="block text-xs font-bold text-gray-600 mb-2">Logo <span class="font-normal text-gray-400">(Opsional)</span></label>
                    <div class="flex items-center gap-4">
                        {{-- Preview --}}
                        <div class="relative w-16 h-16 rounded-xl overflow-hidden border-2 border-gray-300 bg-gray-50 flex items-center justify-center cursor-pointer shrink-0"
                             :class="removeLogo ? 'border-dashed border-red-300 bg-red-50' : (logoPreview ? 'border-solid' : 'border-dashed hover:border-blue-400 hover:bg-blue-50/30')"
                             x-show="true"
                             @click="if(!removeLogo) $refs.logoInput.click()">
                            <template x-if="logoPreview && !removeLogo">
                                <img :src="logoPreview" class="absolute inset-0 w-full h-full object-contain p-1.5">
                            </template>
                            <template x-if="removeLogo">
                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </template>
                            <svg x-show="!logoPreview && !removeLogo" class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 space-y-1.5">
                            <button type="button" @click="$refs.logoInput.click()" x-show="!removeLogo"
                                    class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors block">
                                <span x-text="logoPreview ? 'Ganti Logo' : 'Pilih Logo'"></span>
                            </button>
                            @if($institution->logo)
                            <button type="button"
                                    @click="removeLogo = !removeLogo; if(removeLogo) logoPreview = ''; else logoPreview = '{{ asset('storage/' . $institution->logo) }}'"
                                    class="text-xs font-semibold flex items-center gap-1 transition-colors"
                                    :class="removeLogo ? 'text-gray-500 hover:text-gray-700' : 'text-red-500 hover:text-red-700'">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                <span x-text="removeLogo ? 'Batalkan hapus' : 'Hapus logo'"></span>
                            </button>
                            @endif
                            <p class="text-xs text-gray-400">JPG, PNG, SVG · maks 2MB</p>
                        </div>
                    </div>
                    <input type="file" name="logo" x-ref="logoInput" accept="image/*,image/svg+xml" class="sr-only"
                           @change="const f=$event.target.files[0]; if(f){if(f.size>2097152){alert('Maks 2MB!');return;}logoPreview=URL.createObjectURL(f);removeLogo=false;}">
                    @error('logo')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Kategori Custom Dropdown --}}
                <div class="mb-5" x-data="{
                        open: false,
                        selected: '{{ old('type', $institution->type) }}',
                        label: '{{ $typeLabels[old('type', $institution->type)] ?? old('type', $institution->type) }}'
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
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $institution->is_active) ? 'checked' : '' }}>
                            <div class="w-10 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-700">Tampilkan ke Publik</span>
                            <p class="text-xs text-gray-400">Lembaga terlihat di website</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Info Sistem --}}
            <div class="bg-gray-50 rounded-xl border border-gray-100 p-4 text-xs text-gray-500 space-y-1.5">
                <div class="flex justify-between"><span class="font-semibold text-gray-600">ID</span><span>#{{ $institution->id }}</span></div>
                <div class="flex justify-between"><span class="font-semibold text-gray-600">Dibuat</span><span>{{ $institution->created_at->format('d M Y') }}</span></div>
                <div class="flex justify-between"><span class="font-semibold text-gray-600">Diperbarui</span><span>{{ $institution->updated_at->format('d M Y') }}</span></div>
            </div>

            {{-- Tombol Desktop --}}
            <div class="hidden lg:flex flex-col gap-3">
                <button type="submit" class="w-full px-5 py-3 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">Simpan Perubahan</button>
                <a href="{{ route('admin.institutions.index') }}" class="w-full px-5 py-3 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors text-center">Batal</a>
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
                        <input type="text" name="name" id="name" value="{{ old('name', $institution->name) }}" required maxlength="150"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                        @error('name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi <span class="text-gray-400 font-normal text-xs">(Opsional)</span></label>
                        <textarea name="description" id="description" rows="5"
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm resize-none">{{ old('description', $institution->description) }}</textarea>
                        @error('description')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="contact_person" class="block text-sm font-bold text-gray-700 mb-1">Narahubung <span class="text-gray-400 font-normal text-xs">(Opsional)</span></label>
                        <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $institution->contact_person) }}" maxlength="255"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Nama / No. HP / WhatsApp narahubung lembaga">
                        @error('contact_person')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Galeri Foto --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" x-data="{ newImages: [] }">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Galeri Foto <span class="text-xs font-normal text-gray-400 ml-1">(Opsional)</span></h3>
                        <p class="text-xs text-gray-500 mt-0.5">Foto-foto kegiatan atau dokumentasi lembaga.</p>
                    </div>
                    <button type="button" onclick="document.getElementById('galleryInputEdit').click()"
                            :disabled="({{ count($institution->images ?? []) }} - deletedImages.length + newImages.length) >= 5"
                            class="inline-flex items-center gap-1.5 px-4 py-2 border text-sm font-semibold rounded-lg transition-colors cursor-pointer"
                            :class="({{ count($institution->images ?? []) }} - deletedImages.length + newImages.length) >= 5 ? 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-gray-100'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Foto
                    </button>
                </div>

                {{-- Foto existing --}}
                @if($institution->images && count($institution->images) > 0)
                <div class="mb-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Foto Saat Ini</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @foreach($institution->images as $i => $img)
                        <div class="relative group aspect-square rounded-xl overflow-hidden border border-gray-200 bg-gray-100"
                             x-data="{ removed: false }">
                            <img src="{{ Storage::url($img['path']) }}" class="w-full h-full object-cover transition-all" :class="{ 'opacity-30 scale-95': removed }">
                            <template x-if="removed">
                                <input type="hidden" name="delete_images[]" value="{{ $i }}">
                            </template>
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" :class="{ 'opacity-100': removed }">
                                <button type="button"
                                        @click="removed = !removed; if(removed) { deletedImages.push({{ $i }}); } else { deletedImages = deletedImages.filter(x => x !== {{ $i }}); }"
                                        class="px-3 py-1.5 text-xs font-bold rounded-lg shadow transition-colors"
                                        :class="removed ? 'bg-gray-700 text-white hover:bg-gray-600' : 'bg-red-600 text-white hover:bg-red-700'">
                                    <span x-text="removed ? 'Batalkan' : 'Hapus'"></span>
                                </button>
                            </div>
                            <div x-show="removed" class="absolute top-1.5 right-1.5 w-5 h-5 bg-red-600 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Upload baru --}}
                <div>
                    <div x-show="newImages.length === 0 && {{ $institution->images && count($institution->images) > 0 ? 0 : 1 }}"
                         class="text-center py-6 bg-gray-50/50 rounded-lg border border-dashed border-gray-200">
                        <p class="text-sm text-gray-400">Tambahkan foto baru dengan tombol di atas.</p>
                    </div>

                    {{-- Preview foto baru yang dipilih ditampilkan dari file input langsung --}}
                    <div x-show="newImages.length > 0">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Foto Baru (Menunggu Disimpan)</p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                            <template x-for="(img, index) in newImages" :key="img.id">
                                <div class="relative group aspect-square rounded-xl overflow-hidden border-2 border-dashed border-blue-300 bg-blue-50">
                                    <img :src="img.preview" class="w-full h-full object-cover">
                                    <button type="button" @click="
                                                newImages.splice(index, 1);
                                                let dt = new DataTransfer();
                                                newImages.forEach(img => dt.items.add(img.file));
                                                document.getElementById('galleryInputEdit').files = dt.files;
                                            "
                                            class="absolute top-1.5 right-1.5 w-7 h-7 bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-md">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Ulang file input agar preview baru bisa ditampilkan --}}
                    <input type="file" id="galleryInputEdit" name="gallery[]" accept="image/*" multiple class="sr-only"
                           @change="
                               let dt = new DataTransfer();
                               newImages.forEach(img => dt.items.add(img.file));

                               Array.from($event.target.files).forEach(f => {
                                   let currentTotal = {{ count($institution->images ?? []) }} - deletedImages.length + newImages.length;
                                   if (currentTotal >= 5) {
                                       alert('Maksimal 5 foto galeri secara keseluruhan!');
                                       return;
                                   }
                                   if (f.size > 2097152) {
                                       alert('Maks 2MB per file!');
                                       return;
                                   }
                                   let newImg = { id: Date.now() + Math.random(), preview: URL.createObjectURL(f), file: f };
                                   newImages.push(newImg);
                                   dt.items.add(f);
                               });
                               $event.target.files = dt.files;
                           ">
                </div>
            </div>

            {{-- Anggota / Pengurus --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Pengurus / Anggota</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Edit, hapus, atau tambah anggota baru.</p>
                    </div>
                    <button type="button"
                            @click="members.push({ id: Date.now(), dbId: null, name: '', position: '', photoPreview: '', removePhoto: false, orderNum: members.length + 1, isNew: true })"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-50 border border-blue-200 text-blue-700 text-sm font-semibold rounded-lg hover:bg-blue-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Anggota
                    </button>
                </div>

                <div class="space-y-3">
                    <div x-show="members.length === 0" class="text-center py-8 bg-gray-50/50 rounded-lg border border-dashed border-gray-200">
                        <p class="text-sm text-gray-400">Belum ada pengurus.</p>
                    </div>

                    <template x-for="(member, index) in members" :key="member.id">
                        <div class="flex items-start gap-3 p-4 rounded-xl border transition-colors"
                             :class="member.dbId ? 'bg-gray-50 border-gray-200' : 'bg-blue-50/40 border-blue-200'">
                            <template x-if="member.dbId">
                                <input type="hidden" :name="'members[' + index + '][id]'" :value="member.dbId">
                            </template>
                            <input type="hidden" :name="'members[' + index + '][remove_photo]'" :value="member.removePhoto ? '1' : '0'">

                            {{-- Foto mini --}}
                            <div class="shrink-0">
                                <div class="relative w-14 h-14 rounded-xl overflow-hidden border-2 border-gray-300 bg-white cursor-pointer flex items-center justify-center"
                                     :class="{ 'border-dashed hover:border-blue-400': !member.photoPreview, 'border-solid': member.photoPreview }"
                                     x-show="!member.removePhoto"
                                     @click="document.getElementById('ep_' + member.id).click()">
                                    <template x-if="member.photoPreview && !member.removePhoto">
                                        <img :src="member.photoPreview" class="absolute inset-0 w-full h-full object-cover object-top">
                                    </template>
                                    <svg :class="{ 'opacity-0': member.photoPreview }" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div x-show="member.removePhoto" class="w-14 h-14 rounded-xl border-2 border-dashed border-red-300 bg-red-50 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </div>
                                <input type="file" :name="'members[' + index + '][photo]'" :id="'ep_' + member.id" accept="image/*" class="sr-only"
                                       @change="const f=$event.target.files[0]; if(f){ if(f.size>2097152){alert('Maks 2MB!');$event.target.value='';return;} const reader = new FileReader(); reader.onload = (e) => { document.getElementById('cropperImage').src = e.target.result; currentMemberIndex = index; showCropper = true; }; reader.readAsDataURL(f); }">
                                <button x-show="member.photoPreview && !member.removePhoto && member.dbId" type="button"
                                        @click="member.removePhoto=true;member.photoPreview=''"
                                        class="w-full mt-1 text-[10px] text-red-500 text-center hover:text-red-700 flex items-center justify-center gap-0.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>Hapus
                                </button>
                            </div>

                            {{-- Fields --}}
                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 mb-1">
                                        Nama <span class="text-red-500">*</span>
                                        <span x-show="!member.dbId" class="ml-1 text-[10px] bg-blue-100 text-blue-600 font-bold px-1.5 py-0.5 rounded">Baru</span>
                                    </label>
                                    <input type="text" :name="'members[' + index + '][name]'" :value="member.name" required
                                           class="w-full px-3 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                                           placeholder="Nama anggota...">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 mb-1">Jabatan <span class="text-red-500">*</span></label>
                                    <input type="text" :name="'members[' + index + '][position]'" :value="member.position" required
                                           class="w-full px-3 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                                           placeholder="Ketua, Sekretaris...">
                                </div>
                            </div>

                            {{-- Hapus --}}
                            <button type="button" @click="removeMember(index)"
                                    class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors shrink-0 mt-5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="bg-white rounded-xl shadow-sm border border-red-100 p-6">
                <h3 class="text-sm font-bold text-red-600 mb-2">Zona Berbahaya</h3>
                <p class="text-xs text-gray-500 mb-3">Menghapus lembaga ini akan menghapus seluruh data anggota, logo, dan foto yang terkait. Tindakan ini tidak dapat dibatalkan.</p>
                <button type="submit" form="delete-form"
                        onclick="return confirm('Hapus lembaga {{ addslashes($institution->name) }}? Semua data terkait juga akan terhapus.')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 border border-red-200 text-red-600 text-sm font-semibold rounded-lg hover:bg-red-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus Lembaga Ini
                </button>
            </div>

        </div>{{-- /Kolom Utama --}}
    </div>

    {{-- Tombol Mobile --}}
    <div class="mt-6 flex lg:hidden gap-3">
        <a href="{{ route('admin.institutions.index') }}" class="flex-1 px-4 py-3 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg text-center hover:bg-gray-50 transition-colors">Batal</a>
        <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">Simpan Perubahan</button>
    </div>

    <!-- Modal Cropper -->
    <div x-show="showCropper" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" x-cloak>
        <div class="bg-white rounded-2xl overflow-hidden shadow-2xl w-full max-w-lg" @click.away="showCropper = false">
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-900">Sesuaikan Foto</h3>
                <button type="button" @click="showCropper = false" class="text-gray-400 hover:text-gray-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-4 bg-gray-50 flex justify-center max-h-[60vh] overflow-hidden">
                <img id="cropperImage" class="max-w-full block">
            </div>
            <div class="p-4 border-t border-gray-100 flex justify-end gap-2 bg-white">
                <button type="button" @click="showCropper = false" class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Batal</button>
                <button type="button" @click="applyCrop()" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">Gunakan Foto</button>
            </div>
        </div>
    </div>
</form>

<form id="delete-form" action="{{ route('admin.institutions.destroy', $institution->id) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<style>[x-cloak] { display: none !important; }</style>
@endsection
