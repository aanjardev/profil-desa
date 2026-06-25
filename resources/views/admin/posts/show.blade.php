@extends('layouts.app')

@section('page_title', 'Detail Berita')
@section('page_subtitle', 'Tinjau konten berita secara lengkap.')

@section('content')
<!-- Header & Aksi -->
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar
    </a>

    <div class="flex items-center gap-3">
        @if($post->trashed())
        <!-- Pulihkan -->
        <form action="{{ route('admin.posts.restore', $post->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="px-4 py-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 font-semibold text-sm rounded-lg transition-colors border border-emerald-200">
                Pulihkan
            </button>
        </form>
        @else
        <!-- Arsipkan -->
        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengarsipkan berita ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-amber-50 text-amber-600 hover:bg-amber-100 font-semibold text-sm rounded-lg transition-colors border border-amber-200">
                Arsipkan
            </button>
        </form>
        @endif

        <!-- Edit -->
        <a href="{{ route('admin.posts.edit', $post->id) }}" class="px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 font-semibold text-sm rounded-lg transition-colors border border-blue-200">
            Edit Berita
        </a>

        <!-- Hapus Permanen -->
        <form action="{{ route('admin.posts.force-delete', $post->id) }}" method="POST" onsubmit="return confirm('Peringatan: Berita ini akan dihapus PERMANEN beserta gambarnya. Lanjutkan?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-600 text-white hover:bg-red-700 font-semibold text-sm rounded-lg transition-colors shadow-sm">
                Hapus Permanen
            </button>
        </form>
    </div>
</div>

<!-- Konten Utama -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="Thumbnail" class="w-full h-[400px] object-cover">
            @else
            <div class="w-full h-[400px] bg-gray-100 flex items-center justify-center">
                <span class="text-gray-400 font-medium">Tidak ada gambar thumbnail</span>
            </div>
            @endif
            
            <div class="p-6 md:p-8">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span class="inline-flex px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wide rounded-md">{{ $post->category }}</span>
                    <span class="text-sm text-gray-500 font-medium flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> {{ $post->created_at->format('d M Y, H:i') }}</span>
                    <span class="text-sm text-gray-500 font-medium flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> {{ $post->views }}x dilihat</span>
                </div>

                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 leading-tight">{{ $post->title }}</h1>

                <div class="prose prose-blue max-w-none text-gray-700 leading-relaxed">
                    {!! Str::markdown($post->content) !!}
                </div>

                @if($post->tags)
                <div class="mt-8 pt-6 border-t border-gray-100 flex flex-wrap gap-2">
                    @foreach(explode(',', $post->tags) as $tag)
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">#{{ trim($tag) }}</span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        @if($post->images->count() > 0)
        <!-- Gambar Pendukung -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Gambar Pendukung</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($post->images as $img)
                <div class="group relative aspect-video rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                    <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @if($img->caption)
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-3">
                        <p class="text-white text-xs font-medium line-clamp-2">{{ $img->caption }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Informasi Publikasi</h3>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-3 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Status</span>
                    @if($post->is_published)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Publik
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Draft
                        </span>
                    @endif
                </div>
                
                <div class="flex justify-between items-center pb-3 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Penulis</span>
                    <span class="text-sm font-medium text-gray-900">{{ $post->user->name ?? 'Admin' }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Dibuat pada</span>
                    <span class="text-sm font-medium text-gray-900">{{ $post->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
